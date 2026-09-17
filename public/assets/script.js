const observer=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting)x.target.classList.add('visible')}),{threshold:.12});document.querySelectorAll('.reveal').forEach(el=>observer.observe(el));
let country='all',sector='all';const cards=[...document.querySelectorAll('.project')];function filter(){cards.forEach(card=>card.classList.toggle('hidden',!(country==='all'||card.classList.contains(country))||!(sector==='all'||card.classList.contains(sector))))}document.querySelectorAll('#countries button').forEach(b=>b.onclick=()=>{country=b.dataset.filter;document.querySelectorAll('#countries button').forEach(x=>x.classList.remove('active'));b.classList.add('active');filter()});document.querySelectorAll('#sectors button').forEach(b=>b.onclick=()=>{sector=b.dataset.sector;document.querySelectorAll('#sectors button').forEach(x=>x.classList.remove('active'));b.classList.add('active');filter()});
const stories=[['فريق OX لم يبنِ لنا متجرًا فقط؛ رتّب رحلة العميل كاملة وجعل الفريق يرى الأرقام بشكل أوضح.','سارة العتيبي','CEO، مِرسال · السعودية'],['بدأنا بفكرة تشغيلية معقدة، وانتهينا بمنصة يفهمها العميل وفريق العمليات من أول مرة.','نور الدين','مؤسس، نَهْر · العراق'],['الهدوء في التنفيذ والوضوح في التفاصيل جعلانا نثق في كل خطوة من رحلة المنتج.','عمر مدني','COO، DRIVE+ · الإمارات']];let story=0;const videoCards=[...document.querySelectorAll('.video-card')];function showStory(n){story=(n+stories.length)%stories.length;document.querySelector('#quote-text').textContent=stories[story][0];document.querySelector('#quote-name').textContent=stories[story][1];document.querySelector('#quote-role').textContent=stories[story][2];document.querySelector('#story-count').textContent=`0${story+1}`;videoCards.forEach((card,i)=>card.className=`video-card ${i===story?'active-video':i===(story+2)%3?'side-video previous':'side-video next'}`)}videoCards.forEach((card,i)=>card.onclick=()=>showStory(i));document.querySelector('#story-prev').onclick=()=>showStory(story-1);document.querySelector('#story-next').onclick=()=>showStory(story+1);
const testimonialStyle=document.createElement('style');testimonialStyle.textContent=`.testimonials{background:#342b93;position:relative;overflow:hidden;text-align:center}.testimonials:before{content:'';position:absolute;inset:0;opacity:.4;background-image:radial-gradient(#a6a2ff 1px,transparent 1px),linear-gradient(135deg,#ffffff10,transparent 55%);background-size:13px 13px,100% 100%;mask-image:linear-gradient(90deg,transparent,#000 16%,#000 84%,transparent)}.test-heading,.video-stage,.quote,.story-controls{position:relative;z-index:1}.test-heading h2{font:800 clamp(36px,5vw,71px)/1.15 Alexandria,sans-serif;letter-spacing:-3px;margin:0}.test-heading h2 span{color:#c9fa4b}.test-heading>p:last-child{font-size:11px;line-height:2;color:#d8d6ff;max-width:430px;margin:18px auto}.video-stage{height:390px;max-width:980px;margin:45px auto 20px;display:flex;align-items:center;justify-content:center;gap:20px;perspective:1100px;direction:ltr}.video-card{border:0;color:#fff;position:relative;text-align:right;overflow:hidden;cursor:pointer;background:linear-gradient(145deg,#2b2597,#0d3266);width:255px;height:330px;border-radius:19px;box-shadow:0 26px 55px #09064677;transition:.55s cubic-bezier(.2,.8,.2,1)}.video-card:before{content:'';position:absolute;inset:0;background:linear-gradient(145deg,transparent 20%,#071733c9 91%),repeating-linear-gradient(135deg,#fff1 0 2px,transparent 2px 10px)}.video-card:after{content:'';position:absolute;width:230px;height:230px;border:35px solid #a49cff55;border-radius:50%;left:-85px;top:-110px;animation:oxFloat 5s ease-in-out infinite}.active-video{z-index:3;transform:scale(1.08)}.side-video{opacity:.65;transform:scale(.83)}.previous{transform:rotateY(44deg) scale(.83)}.next{transform:rotateY(-44deg) scale(.83)}.video-card:hover{opacity:1}.video-no{position:absolute;top:18px;right:20px;z-index:2;font:700 12px 'Space Grotesk';color:#c9fa4b}.video-play{position:absolute;z-index:2;top:50%;left:50%;transform:translate(-50%,-50%);display:grid;place-items:center;border:1px solid #fff9;border-radius:50%;width:58px;height:58px;font-size:17px;padding-right:2px;animation:oxPulse 2.2s infinite}.video-ui{position:absolute;bottom:20px;right:21px;z-index:2;display:grid;gap:4px}.video-ui b{font-size:15px}.video-ui small{font-size:9px;color:#d5d9ff}.scan-line{z-index:2;position:absolute;top:0;left:0;right:0;height:2px;background:#c9fa4b;box-shadow:0 0 20px #c9fa4b;animation:oxScan 3s linear infinite}.quote{max-width:680px;margin:30px auto 0}.quote-mark{font:700 70px/20px Georgia;color:#c9fa4b}blockquote{font-size:19px;line-height:2;margin:12px 0 17px}.quote div{display:grid;gap:3px}.quote b{font-size:12px;color:#c9fa4b}.quote small{font-size:9px;color:#d6d5ff}.story-controls{display:flex;align-items:center;justify-content:center;gap:16px;margin-top:30px;direction:ltr}.story-controls button{width:35px;height:35px;border-radius:50%;border:1px solid #aaa5ff;background:transparent;color:white;cursor:pointer}.story-controls span{font:12px 'Space Grotesk';color:#aaa5ff}.story-controls b{color:#c9fa4b}@keyframes oxFloat{50%{transform:translate(18px,24px) rotate(19deg)}}@keyframes oxPulse{50%{box-shadow:0 0 0 12px #ffffff18}}@keyframes oxScan{to{top:100%}}@media(max-width:800px){.video-stage{height:290px;gap:0}.video-card{width:190px;height:255px}.side-video{position:absolute;width:170px;opacity:.35}.previous{margin-right:180px}.next{margin-left:180px}.active-video{transform:scale(1)}blockquote{font-size:15px}.testimonials{padding-right:4vw;padding-left:4vw}}`;document.head.append(testimonialStyle);
// Sector Cards Slider & Interactive Controls
(function initServicesSlider() {
    const viewport = document.getElementById('servicesViewport');
    const track = document.getElementById('servicesCardsTrack');
    const prevBtn = document.getElementById('sectorSlidePrev');
    const nextBtn = document.getElementById('sectorSlideNext');
    const dots = document.querySelectorAll('#sectorDots .dot');
    const cards = document.querySelectorAll('.service-sector-card');

    if (!viewport || !track) return;

    const isRTL = document.documentElement.dir === 'rtl' || document.body.dir === 'rtl';

    function getCardWidth() {
        const firstCard = cards[0];
        if (!firstCard) return 270;
        return firstCard.offsetWidth + 20; // card width + gap
    }

    function updateDots() {
        if (!cards.length) return;
        const cardW = getCardWidth();
        const scrollOffset = Math.abs(viewport.scrollLeft);
        let activeIdx = Math.round(scrollOffset / cardW);
        activeIdx = Math.max(0, Math.min(activeIdx, cards.length - 1));

        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === activeIdx);
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            const step = getCardWidth();
            viewport.scrollBy({ left: isRTL ? step : -step, behavior: 'smooth' });
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            const step = getCardWidth();
            viewport.scrollBy({ left: isRTL ? -step : step, behavior: 'smooth' });
        });
    }

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const targetIdx = parseInt(dot.getAttribute('data-index') || '0', 10);
            const targetCard = cards[targetIdx];
            if (targetCard) {
                targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        });
    });

    viewport.addEventListener('scroll', updateDots, { passive: true });

    // Drag to scroll
    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;

    viewport.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - viewport.offsetLeft;
        scrollLeft = viewport.scrollLeft;
    });

    viewport.addEventListener('mouseleave', () => { isDown = false; });
    viewport.addEventListener('mouseup', () => { isDown = false; });

    viewport.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - viewport.offsetLeft;
        const walk = (x - startX) * 1.6;
        viewport.scrollLeft = scrollLeft - walk;
    });
})();
