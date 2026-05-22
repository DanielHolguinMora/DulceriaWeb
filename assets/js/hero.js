document.addEventListener('DOMContentLoaded', () => {
  const isMobile = window.innerWidth <= 768 || /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

  // --- Custom Cursor Logic ---
  const cursor = document.getElementById('cursor');
  const ring = document.getElementById('cursor-ring');
  const hero = document.getElementById('hero');

  let mx = 0, my = 0, rx = 0, ry = 0;
  let isHoveringHero = false;

  window.addEventListener('mousemove', e => {
    mx = e.clientX;
    my = e.clientY;
  });

  function animCursor() {
    rx += (mx - rx) * 0.18;
    ry += (my - ry) * 0.18;

    if (cursor && ring) {
      cursor.style.left = mx + 'px';
      cursor.style.top = my + 'px';

      ring.style.left = rx + 'px';
      ring.style.top = ry + 'px';
    }

    requestAnimationFrame(animCursor);
  }

  animCursor();

  // Custom cursor active state inside #hero
  if (hero) {
    hero.addEventListener('mouseenter', () => {
      isHoveringHero = true;
      document.body.classList.add('hero-hover');
    });

    hero.addEventListener('mouseleave', () => {
      isHoveringHero = false;
      document.body.classList.remove('hero-hover');
    });

    // Also check on scroll to make sure cursor returns when scrolled away
    window.addEventListener('scroll', () => {
      const heroHeight = hero.offsetHeight;
      if (window.scrollY > heroHeight - 50) {
        document.body.classList.remove('hero-hover');
      } else if (isHoveringHero) {
        document.body.classList.add('hero-hover');
      }
    });
  }

  // Custom cursor hover expansions on links and buttons
  const interactiveElements = 'a, button, .btn, .product-card, .fav-btn';
  document.addEventListener('mouseover', e => {
    if (document.body.classList.contains('hero-hover') && e.target.closest(interactiveElements)) {
      cursor.classList.add('hovered');
      ring.classList.add('hovered');
    }
  });

  document.addEventListener('mouseout', e => {
    if (e.target.closest(interactiveElements)) {
      cursor.classList.remove('hovered');
      ring.classList.remove('hovered');
    }
  });

  // --- Three.js WebGL Interactive Canvas ---
  const canvas = document.getElementById('hero-canvas');
  if (!canvas) return;

  const W = canvas.offsetWidth;
  const H = canvas.offsetHeight;

  const renderer = new THREE.WebGLRenderer({
    canvas,
    antialias: true,
    alpha: true
  });

  renderer.setSize(W, H);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setClearColor(0x000000, 0);

  const scene = new THREE.Scene();

  const camera = new THREE.PerspectiveCamera(52, W / H, 0.1, 100);
  camera.position.set(0, 0.4, 7);

  if (isMobile) {
    camera.position.set(0, 0.2, 8.5);
    camera.fov = 48;
    camera.updateProjectionMatrix();
  }

  scene.fog = new THREE.FogExp2(0x1ccaf4, 0.055);

  scene.add(new THREE.AmbientLight(0xFDE3CF, 0.5));

  const keyLight = new THREE.DirectionalLight(0xF8A91F, 3.5);
  keyLight.position.set(-3, 6, 5);
  scene.add(keyLight);

  const fillLight = new THREE.PointLight(0xEC6426, 5, 18);
  fillLight.position.set(4, -2, 3);
  scene.add(fillLight);

  const lollipop = new THREE.Group();
  scene.add(lollipop);

  const coreGeo = new THREE.SphereGeometry(1.55, 64, 64);

  const coreMat = new THREE.MeshStandardMaterial({
    color: 0xff0000,
    roughness: 0.08,
    metalness: 0.6,
    emissive: 0x6a1a05,
    emissiveIntensity: 0.25,
  });

  const core = new THREE.Mesh(coreGeo, coreMat);
  core.castShadow = true;
  lollipop.add(core);

  const glassGeo = new THREE.SphereGeometry(1.58, 64, 64);
  const glassMat = new THREE.MeshStandardMaterial({
    color: 0xd70000,
    roughness: 0.0,
    metalness: 0.0,
    transparent: true,
    opacity: 0.18,
    side: THREE.FrontSide,
  });

  const glass = new THREE.Mesh(glassGeo, glassMat);
  lollipop.add(glass);

  const stickGeo = new THREE.CylinderGeometry(0.055, 0.08, 3.6, 20);

  const stickMat = new THREE.MeshStandardMaterial({
    color: 0xf3f1ff,
    roughness: 0.35,
    metalness: 0.15,
    emissive: 0xFDE3CF,
    emissiveIntensity: 0.04,
  });

  const stick = new THREE.Mesh(stickGeo, stickMat);
  stick.position.y = -2.6;
  stick.rotation.z = 0.12;
  lollipop.add(stick);

  for (let i = 0; i < 6; i++) {
    const stripeGeo = new THREE.CylinderGeometry(0.062, 0.062, 0.18, 16);

    const stripeMat = new THREE.MeshStandardMaterial({
      color: i % 2 === 0 ? 0xff5757 : 0xffc0c0,
      roughness: 0.3,
      metalness: 0.2,
      emissive: i % 2 === 0 ? 0xff5757 : 0xffc0c0,
      emissiveIntensity: 0.12,
    });

    const stripe = new THREE.Mesh(stripeGeo, stripeMat);
    stripe.position.y = -1.1 - i * 0.52;
    stripe.rotation.z = 0.12;

    lollipop.add(stripe);
  }

  function makeRing(radius, tube, color, tiltX, tiltZ) {
    const geo = new THREE.TorusGeometry(radius, tube, 24, 120);

    const mat = new THREE.MeshStandardMaterial({
      color,
      roughness: 0.05,
      metalness: 0.95,
      emissive: color,
      emissiveIntensity: .2,
      transparent: true,
      opacity: 0.75,
    });

    const mesh = new THREE.Mesh(geo, mat);
    mesh.rotation.x = tiltX;
    mesh.rotation.z = tiltZ;

    return mesh;
  }

  const ring1 = makeRing(2.4, 0.04, 0xe9fa00, Math.PI / 2.3, 0.5);
  const ring2 = makeRing(2.9, 0.03, 0xedff16, Math.PI / 3.2, -0.7);
  const ring3 = makeRing(3.4, 0.022, 0xbcc300, Math.PI / 1.6, 0.25);

  scene.add(ring1, ring2, ring3);

  const COUNT = isMobile ? 80 : 220;

  const positions = new Float32Array(COUNT * 3);
  const colorsArr = new Float32Array(COUNT * 3);

  const palette = [
    new THREE.Color(0xff0004),
    new THREE.Color(0xff2326),
    new THREE.Color(0xffddde),
    new THREE.Color(0x920a0c),
    new THREE.Color(0xff9496),
  ];

  for (let i = 0; i < COUNT; i++) {
    const r = 3.0 + Math.random() * 3.2;
    const theta = Math.random() * Math.PI * 2;
    const phi = Math.acos(2 * Math.random() - 1);

    positions[i * 3] = r * Math.sin(phi) * Math.cos(theta);
    positions[i * 3 + 1] = r * Math.sin(phi) * Math.sin(theta);
    positions[i * 3 + 2] = r * Math.cos(phi);

    const c = palette[Math.floor(Math.random() * palette.length)];

    colorsArr[i * 3] = c.r;
    colorsArr[i * 3 + 1] = c.g;
    colorsArr[i * 3 + 2] = c.b;
  }

  const particleGeo = new THREE.BufferGeometry();
  particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  particleGeo.setAttribute('color', new THREE.BufferAttribute(colorsArr, 3));

  const particleMat = new THREE.PointsMaterial({
    size: 0.055,
    vertexColors: true,
    transparent: true,
    opacity: .85,
    sizeAttenuation: true,
  });

  const particles = new THREE.Points(particleGeo, particleMat);
  scene.add(particles);

  const miniLollipops = [];

  const miniColors = [
    0x2c8ecb,
    0xdb6c34,
    0x3bed51,
    0x2c10ff,
    0xefd320,
    0xff2aa6
  ];

  for (let i = 0; i < 6; i++) {
    const group = new THREE.Group();

    const headGeo = new THREE.SphereGeometry(0.18, 20, 20);

    const headMat = new THREE.MeshStandardMaterial({
      color: miniColors[i],
      roughness: 0.1,
      metalness: 0.7,
      emissive: miniColors[i],
      emissiveIntensity: 0.25,
    });

    const head = new THREE.Mesh(headGeo, headMat);
    group.add(head);

    const miniStickGeo = new THREE.CylinderGeometry(0.025, 0.025, 0.6, 8);

    const miniStickMat = new THREE.MeshStandardMaterial({
      color: 0xf3f1ff,
      roughness: 0.4,
    });

    const miniStick = new THREE.Mesh(miniStickGeo, miniStickMat);
    miniStick.position.y = -0.4;

    group.add(miniStick);

    const angle = (i / 6) * Math.PI * 2;
    const radius = 2.6 + (i % 2) * 0.5;

    group.userData = {
      angle,
      radius,
      speed: 0.25 + Math.random() * 0.3,
      yOff: (Math.random() - .5) * 1.8
    };

    scene.add(group);
    miniLollipops.push(group);
  }

  let mouseX = 0;
  let mouseY = 0;

  window.addEventListener('mousemove', e => {
    // Normalize coordinates -1 to +1
    mouseX = (e.clientX / window.innerWidth - .5) * 2;
    mouseY = (e.clientY / window.innerHeight - .5) * 2;
  });

  window.addEventListener('resize', () => {
    const W2 = canvas.offsetWidth;
    const H2 = canvas.offsetHeight;

    camera.aspect = W2 / H2;
    camera.updateProjectionMatrix();

    renderer.setSize(W2, H2);
  });

  const clock = new THREE.Clock();

  function animate() {
    requestAnimationFrame(animate);

    const t = clock.getElapsedTime();

    lollipop.position.y = Math.sin(t * 0.9) * 0.18;
    lollipop.rotation.y = t * 0.22;
    lollipop.rotation.z = Math.sin(t * 0.6) * 0.06;

    glass.material.opacity = 0.14 + Math.sin(t * 2.1) * 0.06;

    ring1.rotation.y = t * 0.45;
    ring2.rotation.y = -t * 0.28;
    ring2.rotation.x = t * 0.12 + Math.PI / 3;
    ring3.rotation.z = t * 0.2;
    ring3.rotation.x = t * 0.5;

    particles.rotation.y = t * 0.04;
    particles.rotation.x = t * 0.018;

    miniLollipops.forEach(ml => {
      ml.userData.angle += 0.006 * ml.userData.speed;

      const a = ml.userData.angle;
      const r = ml.userData.radius;

      ml.position.x = Math.cos(a) * r;
      ml.position.z = Math.sin(a) * r;
      ml.position.y = ml.userData.yOff + Math.sin(t * ml.userData.speed) * 0.6;

      ml.rotation.y = t * 1.5;
      ml.rotation.z = Math.sin(t * 0.8 + a) * 0.4;
    });

    fillLight.position.x = mouseX * 5;
    fillLight.position.y = -mouseY * 4;

    camera.position.x += (mouseX * 1.4 - camera.position.x) * 0.035;
    camera.position.y += (-mouseY * 0.9 + 0.4 - camera.position.y) * 0.035;

    camera.lookAt(0, 0.3, 0);

    renderer.render(scene, camera);
  }

  animate();
});
