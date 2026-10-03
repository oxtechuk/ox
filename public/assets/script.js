const observer=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting)x.target.classList.add('visible')}),{threshold:.12});document.querySelectorAll('.reveal').forEach(el=>observer.observe(el));
let country='all',sector='all';const cards=[...document.querySelectorAll('.project')];function filter(){cards.forEach(card=>card.classList.toggle('hidden',!(country==='all'||card.classList.contains(country))||!(sector==='all'||card.classList.contains(sector))))}document.querySelectorAll('#countries button').forEach(b=>b.onclick=()=>{country=b.dataset.filter;document.querySelectorAll('#countries button').forEach(x=>x.classList.remove('active'));b.classList.add('active');filter()});document.querySelectorAll('#sectors button').forEach(b=>b.onclick=()=>{sector=b.dataset.sector;document.querySelectorAll('#sectors button').forEach(x=>x.classList.remove('active'));b.classList.add('active');filter()});
const stories=[['فريق OX لم يبنِ لنا متجرًا فقط؛ رتّب رحلة العميل كاملة وجعل الفريق يرى الأرقام بشكل أوضح.','سارة العتيبي','CEO، مِرسال · السعودية'],['بدأنا بفكرة تشغيلية معقدة، وانتهينا بمنصة يفهمها العميل وفريق العمليات من أول مرة.','نور الدين','مؤسس، نَهْر · العراق'],['الهدوء في التنفيذ والوضوح في التفاصيل جعلانا نثق في كل خطوة من رحلة المنتج.','عمر مدني','COO، DRIVE+ · الإمارات']];let story=0;const videoCards=[...document.querySelectorAll('.video-card')];function showStory(n){story=(n+stories.length)%stories.length;document.querySelector('#quote-text').textContent=stories[story][0];document.querySelector('#quote-name').textContent=stories[story][1];document.querySelector('#quote-role').textContent=stories[story][2];document.querySelector('#story-count').textContent=`0${story+1}`;videoCards.forEach((card,i)=>card.className=`video-card ${i===story?'active-video':i===(story+2)%3?'side-video previous':'side-video next'}`)}videoCards.forEach((card,i)=>card.onclick=()=>showStory(i));document.querySelector('#story-prev').onclick=()=>showStory(story-1);document.querySelector('#story-next').onclick=()=>showStory(story+1);
// Testimonials styling is defined in ox-theme.css with official OX Tech identity
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
