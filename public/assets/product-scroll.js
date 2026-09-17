import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';
import Lenis from 'lenis';
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

gsap.registerPlugin(ScrollTrigger, SplitText);

function initShowcase() {
    const container = document.querySelector('.model-container');
    const showcaseRoot = document.querySelector('.showcase-root');
    if (!container || !showcaseRoot) return;

    /* ─── 1. Smooth Scroll Bridge (Lenis) ────────────────────────── */
    const lenis = new Lenis();
    lenis.on('scroll', ScrollTrigger.update);
    const driveLenis = (time) => lenis.raf(time * 1000);
    gsap.ticker.add(driveLenis);
    gsap.ticker.lagSmoothing(0);

    /* ─── 2. SplitText Setup (Multilingual: AR / EN / FR) ────────── */
    const h1El = document.querySelector('.header-1 h1');
    const isArabic = /[\u0600-\u06FF]/.test(h1El ? h1El.textContent : '');

    const header1Split = new SplitText('.header-1 h1', {
        type: isArabic ? 'words' : 'chars',
        charsClass: 'char',
        wordsClass: 'word'
    });
    const splitItems = isArabic ? header1Split.words : header1Split.chars;
    splitItems.forEach(item => {
        item.innerHTML = `<span>${item.innerHTML}</span>`;
    });

    document.querySelectorAll('.tooltip .title h2').forEach(el => {
        const s = new SplitText(el, { type: 'lines', linesClass: 'line' });
        s.lines.forEach(l => { l.innerHTML = `<span>${l.innerHTML}</span>`; });
    });

    document.querySelectorAll('.tooltip .description p').forEach(el => {
        const s = new SplitText(el, { type: 'lines', linesClass: 'line' });
        s.lines.forEach(l => { l.innerHTML = `<span>${l.innerHTML}</span>`; });
    });

    /* ─── 3. Three.js Scene Setup ────────────────────────────────── */
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setClearColor(0x000000, 0);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;

    if (THREE.SRGBColorSpace) {
        renderer.outputColorSpace = THREE.SRGBColorSpace;
    } else if (THREE.LinearEncoding) {
        renderer.outputEncoding = THREE.LinearEncoding;
    }
    renderer.toneMapping = THREE.NoToneMapping;
    renderer.toneMappingExposure = 1.0;

    container.appendChild(renderer.domElement);

    // Lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
    scene.add(ambientLight);

    const mainLight = new THREE.DirectionalLight(0xffffff, 1.0);
    mainLight.position.set(1, 2, 3);
    mainLight.castShadow = true;
    mainLight.shadow.bias = -0.001;
    mainLight.shadow.mapSize.set(1024, 1024);
    scene.add(mainLight);

    const fillLight = new THREE.DirectionalLight(0xffffff, 0.5);
    fillLight.position.set(-2, 0, -2);
    scene.add(fillLight);

    // Luxury Homepage Brand Accent Lights (Neon Lime & Tech Blue Rim Highlights)
    const limeRim = new THREE.DirectionalLight(0xc9fa4b, 0.4);
    limeRim.position.set(-2.5, 3, 2);
    scene.add(limeRim);

    const blueRim = new THREE.DirectionalLight(0x1f63ff, 0.45);
    blueRim.position.set(2.5, -2, -2);
    scene.add(blueRim);

    let model = null;
    let modelSize = null;
    let currentRotation = 0;

    function setupModel() {
        if (!model || !modelSize) return;
        const isMobile = window.innerWidth < 1000;
        const center = new THREE.Box3().setFromObject(model).getCenter(new THREE.Vector3());
        const size = modelSize;
        const maxDimension = Math.max(size.x, size.y, size.z);

        model.position.set(
            isMobile ? center.x + size.x * 1 : -center.x - size.x * 0.4,
            -center.y + size.y * 0.085,
            -center.z
        );
        model.rotation.z = isMobile ? 0 : -25 * (Math.PI / 180);

        const d = isMobile ? 2 : 1.25;
        camera.position.set(0, 0, maxDimension * d);
        camera.lookAt(0, 0, 0);
    }

    const modelUrl = container.dataset.modelUrl || 'shaker.glb';
    const gltfLoader = new GLTFLoader();
    gltfLoader.load(
        modelUrl,
        (gltf) => {
            model = gltf.scene;
            model.traverse(child => {
                if (child.isMesh && child.material) {
                    const mats = Array.isArray(child.material) ? child.material : [child.material];
                    mats.forEach(m => {
                        m.metalness = 0.1;
                        m.roughness = 0.8;
                        m.side = THREE.DoubleSide;
                        m.needsUpdate = true;
                    });
                }
            });
            const box = new THREE.Box3().setFromObject(model);
            modelSize = box.getSize(new THREE.Vector3());
            scene.add(model);
            setupModel();
        },
        undefined,
        (error) => {
            console.error('Failed to load GLTF shaker model:', error);
            if (modelUrl !== 'shaker.glb') {
                gltfLoader.load('shaker.glb', (gltf) => {
                    model = gltf.scene;
                    const box = new THREE.Box3().setFromObject(model);
                    modelSize = box.getSize(new THREE.Vector3());
                    scene.add(model);
                    setupModel();
                });
            }
        }
    );

    function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
        setupModel();
    });

    /* ─── 4. Shared Tween Options ───────────────────────────────── */
    const animOptions = { duration: 1, ease: 'power3.out', stagger: 0.025 };

    /* ─── 5. ScrollTrigger #1 — Header-1 reveal on approach ─────── */
    const targetHeader1Selector = isArabic ? '.header-1 h1 .word > span' : '.header-1 h1 .char > span';
    ScrollTrigger.create({
        trigger: '.product-overview',
        start: '75% bottom',
        onEnter: () => {
            gsap.to(targetHeader1Selector, {
                y: '0%', duration: 1, ease: 'power3.out', stagger: isArabic ? 0.08 : 0.025
            });
        },
        onLeaveBack: () => {
            gsap.to(targetHeader1Selector, {
                y: '100%', duration: 1, ease: 'power3.out', stagger: isArabic ? 0.08 : 0.025
            });
        }
    });

    /* ─── 6. ScrollTrigger #2 — Pinned scrub timeline (compact & snappy) ─ */
    ScrollTrigger.create({
        trigger: '.product-overview',
        start: 'top top',
        end: '+=' + (window.innerHeight * 2.2) + 'px',
        pin: true,
        pinSpacing: true,
        scrub: 0.8,
        onUpdate: ({ progress }) => {

            /* 1. Header 1 slides out left (0.02 → 0.28) */
            let xP1 = 0;
            if (progress >= 0.28) xP1 = -100;
            else if (progress > 0.02) xP1 = -100 * ((progress - 0.02) / 0.26);
            gsap.to('.header-1', { xPercent: xP1 });

            /* 2. Circular mask expands (0.10 → 0.26) */
            let maskSize = 0;
            if (progress >= 0.26) maskSize = 100;
            else if (progress > 0.10) maskSize = 100 * ((progress - 0.10) / 0.16);
            gsap.to('.circular-mask', { clipPath: `circle(${maskSize}% at 50% 50%)` });

            /* 3. Header 2 sweeps across (0.08 → 0.44) */
            let xP2 = 100;
            if (progress >= 0.44) xP2 = -200;
            else if (progress > 0.08) xP2 = 100 - 300 * ((progress - 0.08) / 0.36);
            gsap.to('.header-2', {
                xPercent: xP2,
                opacity: (progress >= 0.07 && progress <= 0.46) ? 1 : 0
            });

            /* 4. Dividers grow (0.34 → 0.52) */
            let scaleX = 0;
            if (progress >= 0.52) scaleX = 100;
            else if (progress > 0.34) scaleX = 100 * ((progress - 0.34) / 0.18);
            gsap.to('.tooltip .divider', { scaleX: `${scaleX}%`, ...animOptions });

            /* 5. Tooltip content reveals (threshold toggles) */
            const t1Active = progress >= 0.48;
            const t2Active = progress >= 0.68;

            const t1El = document.querySelector('.tooltip:nth-child(1)');
            const t2El = document.querySelector('.tooltip:nth-child(2)');

            if (t1El) {
                if (t1Active) t1El.classList.add('is-active');
                else t1El.classList.remove('is-active');
            }
            if (t2El) {
                if (t2Active) t2El.classList.add('is-active');
                else t2El.classList.remove('is-active');
            }

            // Animate Tooltip 1 card fade in / out
            gsap.to('.tooltip:nth-child(1)', {
                opacity: t1Active ? 1 : 0,
                y: t1Active ? 0 : 25,
                duration: 0.35,
                ease: 'power2.out'
            });

            // Tooltip 1 inner items
            gsap.to([
                '.tooltip:nth-child(1) .icon ion-icon',
                '.tooltip:nth-child(1) .title .line > span',
                '.tooltip:nth-child(1) .description .line > span'
            ], { y: t1Active ? '0%' : '125%', ...animOptions });

            // Animate Tooltip 2 card fade in / out
            gsap.to('.tooltip:nth-child(2)', {
                opacity: t2Active ? 1 : 0,
                y: t2Active ? 0 : 25,
                duration: 0.35,
                ease: 'power2.out'
            });

            // Tooltip 2 inner items
            gsap.to([
                '.tooltip:nth-child(2) .icon ion-icon',
                '.tooltip:nth-child(2) .title .line > span',
                '.tooltip:nth-child(2) .description .line > span'
            ], { y: t2Active ? '0%' : '125%', ...animOptions });

            /* 6. Model rotation (local Y-axis spin delta) */
            if (model && progress >= 0.02) {
                const rotationProgress = Math.min(Math.max((progress - 0.02) / 0.96, 0), 1);
                const targetRotation = Math.PI * 2 * 2.5 * rotationProgress;
                const diff = targetRotation - currentRotation;
                if (Math.abs(diff) > 0.001) {
                    model.rotateOnAxis(new THREE.Vector3(0, 1, 0), diff);
                    currentRotation = targetRotation;
                }
            }
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initShowcase);
} else {
    initShowcase();
}
