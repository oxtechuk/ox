import { createHmac } from "crypto";
import dayjs from "dayjs";
import fetch from "node-fetch";
import { prodApiUrl, testApiUrl, testConfig } from "./constants";

import {
  CheckoutHashData,
  FilterTransactionsHashData,
  HashData,
  InstanceConfig,
  MoamalatConfig,
  TransactionsResponse,
  TransactionsFilterOptions,
  Reference,
} from "./types";

class Moamalat {
  private merchantId: string;
  private terminalId: string;
  private secureKey: string;

  private apiUrl: string;

  constructor({
    merchantId,
    terminalId,
    secureKey = "",
    prod,
  }: InstanceConfig = testConfig) {
    this.merchantId = merchantId;
    this.terminalId = terminalId;
    this.secureKey = secureKey;

    this.apiUrl = prod ? prodApiUrl : testApiUrl;
  }

  /**
   * @param amount amount to be paid in LYD
   * @param reference marchant reference e.g. invoice id
   * @param date date of checkout, default is new Date()
   */
  checkout(
    amount: number,
    reference: string | number = "",
    date: string | Date = new Date()
  ): MoamalatConfig {
    const dateTime = dayjs(date).format("YYYYMMDDHHmm");

    const _amount = amount * 1000;

    const hashData: CheckoutHashData = {
      MerchantId: this.merchantId,
      TerminalId: this.terminalId,
      Amount: _amount.toString(),
      DateTimeLocalTrxn: dateTime,
      MerchantReference: reference.toString(),
    };

    return {
      MID: this.merchantId,
      TID: this.terminalId,
      AmountTrxn: _amount,
      MerchantReference: reference.toString(),
      TrxDateTime: dateTime,
      SecureHash: this.generateSecureHash(hashData),
    };
  }

  /**
   * @param reference marchant reference e.g. invoice id
   */
  async transactionApproved(reference: Reference): Promise<boolean> {
    const transactions = await this.transactions(reference);

    let approved = false;

    if (transactions.Transactions?.length) {
      approved =
        transactions.Transactions[0].DateTransactions[0].Status === "Approved";
    }

    return approved;
  }

  /**
   * @param reference marchant reference e.g. invoice id
   * @param optoins filter options
   */
  async transactions(
    reference: Reference | null | undefined,
    optoins: Partial<TransactionsFilterOptions> = {}
  ): Promise<TransactionsResponse> {
    const hashData: FilterTransactionsHashData = {
      MerchantId: this.merchantId,
      TerminalId: this.terminalId,
      DateTimeLocalTrxn: dayjs().format("YYYYMMDDHHmmss"),
    };

    const {
      displayLength = 1,
      displayStart = 0,
      dateFrom,
      dateTo,
      sortCol,
      sortDir,
    } = optoins;

    const body = {
      ...hashData,
      MerchantReference: reference?.toString(),
      DisplayLength: displayLength,
      DisplayStart: displayStart,
      DateFrom: dateFrom && dayjs(dateFrom).format("YYYYMMDD"),
      DateTo: dateTo && dayjs(dateTo).format("YYYYMMDD"),
      SortCol: sortCol,
      SortDir: sortDir,
      SecureHash: this.generateSecureHash(hashData),
    };

    const res = await fetch(
      this.apiUrl + "/cube/paylink.svc/api/FilterTransactions",
      {
        headers: {
          "Content-Type": "application/json",
        },
        method: "POST",
        body: JSON.stringify(body),
      }
    );

    const data: TransactionsResponse = await res.json();

    return data;
  }

  private generateSecureHash(hashData: HashData) {
    const params = new URLSearchParams(hashData);

    params.sort();

    const data = params.toString();

    const key = Buffer.from(this.secureKey, "hex");

    const hmac = createHmac("sha256", key).update(data).digest("hex");

    return hmac;
  }
}

export default Moamalat;
