//mouse-foloower
function MouseFollowerType1(clientId, options = {}) {
  const canvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d');

  const dotColor = options.background || 'rgba(0, 255, 255, 0.5)';
  const dotSize = options.size || 10;
  const smoothness = options.decay || 0.1;

  const pos = { x: 0, y: 0 };
  const mouse = { x: 0, y: 0 };
  let visible = false;

  canvas.style.position = 'fixed';
  canvas.style.top = 0;
  canvas.style.left = 0;
  canvas.style.width = '100vw';
  canvas.style.height = '100vh';
  canvas.style.pointerEvents = 'none';
  canvas.style.zIndex = 9999;
  canvas.style.display = 'none';

  document.body.appendChild(canvas);

  const resize = () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  };
  resize();
  window.addEventListener('resize', resize);

  const render = () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    pos.x += (mouse.x - pos.x) * smoothness;
    pos.y += (mouse.y - pos.y) * smoothness;

    ctx.beginPath();
    ctx.arc(pos.x, pos.y, dotSize, 0, Math.PI * 2);
    ctx.fillStyle = dotColor;
    ctx.shadowBlur = 20;
    ctx.shadowColor = dotColor;
    ctx.fill();

    requestAnimationFrame(render);
  };
  render();

  const handleMove = (e) => {
    if (!visible) return;
    mouse.x = e.clientX;
    mouse.y = e.clientY;
  };

  const target = document.querySelector(`[data-block="${clientId}"]`);
  if (!target) return;

  target.addEventListener('mouseenter', () => {
    visible = true;
    canvas.style.display = 'block';
  });

  target.addEventListener('mouseleave', () => {
    visible = false;
    canvas.style.display = 'none';
  });

  document.addEventListener('mousemove', handleMove);
}

function MouseFollowerType2(clientId, style = {}) {
  const dotColor = style.background || 'rgba(0, 123, 255, 1)';
  const dotSize = style.size || 6;

  const canvas = document.createElement('canvas');
  canvas.style.position = 'fixed';
  canvas.style.top = '0';
  canvas.style.left = '0';
  canvas.style.width = '100vw';
  canvas.style.height = '100vh';
  canvas.style.pointerEvents = 'none';
  canvas.style.zIndex = '9999';
  canvas.style.display = 'none';
  document.body.appendChild(canvas);

  const ctx = canvas.getContext('2d');
  let isVisible = false;
  const positions = [];

  function applyAlphaToColor(color, alpha) {
    if (color.startsWith('rgba')) {
      return color.replace(/rgba?\(([^)]+)\)/, (_, values) => {
        const [r, g, b] = values.split(',').map(v => parseFloat(v.trim()));
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
      });
    } else if (color.startsWith('rgb')) {
      return color.replace(/rgb\(([^)]+)\)/, (_, values) => {
        const [r, g, b] = values.split(',').map(v => parseFloat(v.trim()));
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
      });
    }
    return color;
  }

  function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  resizeCanvas();
  window.addEventListener('resize', resizeCanvas);

  let animationFrameId;

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < positions.length; i++) {
      const { x, y, alpha } = positions[i];
      ctx.beginPath();
      ctx.arc(x, y, dotSize, 0, Math.PI * 2);
      ctx.fillStyle = applyAlphaToColor(dotColor, alpha);
      ctx.fill();
    }

    for (let i = positions.length - 1; i >= 0; i--) {
      positions[i].alpha -= 0.02;
      if (positions[i].alpha <= 0) {
        positions.splice(i, 1);
      }
    }

    canvas.style.display = isVisible || positions.length > 0 ? 'block' : 'none';
    animationFrameId = requestAnimationFrame(draw);
  }

  function handleMouseMove(e) {
    if (!isVisible) return;
    positions.push({ x: e.clientX, y: e.clientY, alpha: 1 });
  }

  const target = document.querySelector(`[data-block="${clientId}"]`);
  if (!target) return;

  function handleEnter() {
    isVisible = true;
  }

  function handleLeave() {
    isVisible = false;
  }

  document.addEventListener('mousemove', handleMouseMove);
  target.addEventListener('mouseenter', handleEnter);
  target.addEventListener('mouseleave', handleLeave);

  draw();

  // Optional: cleanup
  return () => {
    cancelAnimationFrame(animationFrameId);
    document.removeEventListener('mousemove', handleMouseMove);
    window.removeEventListener('resize', resizeCanvas);
    target.removeEventListener('mouseenter', handleEnter);
    target.removeEventListener('mouseleave', handleLeave);
    canvas.remove();
  };
}

function MouseFollowerType3(clientId, { background }) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.style.position = 'fixed';
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = 9999;
    document.body.appendChild(canvas);

    const particles = [];

    const getRGBA = (color, alpha) => {
        if (!color) return `rgba(173,216,230,${alpha})`;
        if (color.startsWith('rgba')) {
            return color.replace(/[\d.]+\)$/g, `${alpha})`);
        }
        if (color.startsWith('rgb')) {
            return color.replace('rgb', 'rgba').replace(/\)$/, `,${alpha})`);
        }
        const hex = color.replace('#', '');
        const bigint = parseInt(hex, 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;
        return `rgba(${r},${g},${b},${alpha})`;
    };

    const resizeCanvas = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    const spawnParticles = (x, y) => {
        for (let i = 0; i < 3; i++) {
            particles.push({
                x,
                y,
                dx: (Math.random() - 0.5) * 2,
                dy: (Math.random() - 0.5) * 2,
                alpha: 1,
                size: Math.random() * 4 + 2,
            });
        }
    };

    let visible = false;

    const draw = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            ctx.fillStyle = getRGBA(background, p.alpha);
            ctx.fill();
        });

        for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];
            p.x += p.dx;
            p.y += p.dy;
            p.alpha -= 0.02;
            if (p.alpha <= 0) {
                particles.splice(i, 1);
            }
        }

        requestAnimationFrame(draw);
    };
    draw();

    const block = document.querySelector(`[data-block="${clientId}"]`);
    if (!block) return;

    const handleMouseMove = (e) => {
        if (!visible) return;
        spawnParticles(e.clientX, e.clientY);
    };

    const handleEnter = () => {
        visible = true;
        canvas.style.display = 'block';
    };
    const handleLeave = () => {
        visible = false;
        canvas.style.display = 'none';
    };

    document.addEventListener('mousemove', handleMouseMove);
    block.addEventListener('mouseenter', handleEnter);
    block.addEventListener('mouseleave', handleLeave);
}

function MouseFollowerType4(clientId, { background }) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.style.position = 'fixed';
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = 9999;
    document.body.appendChild(canvas);

    let visible = false;
    const points = [];

    const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    const render = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.beginPath();

        for (let i = 0; i < points.length - 1; i++) {
            const p1 = points[i];
            const p2 = points[i + 1];

            let stroke = background;
            if (stroke?.startsWith('rgba')) {
                stroke = stroke.replace(/rgba\((\d+),\s*(\d+),\s*(\d+),\s*[\d.]+\)/, `rgba($1, $2, $3, ${p1.alpha})`);
            }

            ctx.strokeStyle = stroke;
            ctx.lineWidth = 2;
            ctx.moveTo(p1.x, p1.y);
            ctx.lineTo(p2.x, p2.y);
            ctx.stroke();
        }

        for (let i = points.length - 1; i >= 0; i--) {
            points[i].alpha -= 0.02;
            if (points[i].alpha <= 0) points.splice(i, 1);
        }

        requestAnimationFrame(render);
    };
    render();

    const block = document.querySelector(`[data-block="${clientId}"]`);
    if (!block) return;

    const handleMove = (e) => {
        if (!visible) return;
        points.push({ x: e.clientX, y: e.clientY, alpha: 1 });
    };

    const handleEnter = () => {
        visible = true;
        canvas.style.display = 'block';
    };

    const handleLeave = () => {
        visible = false;
        canvas.style.display = 'none';
    };

    document.addEventListener('mousemove', handleMove);
    block.addEventListener('mouseenter', handleEnter);
    block.addEventListener('mouseleave', handleLeave);
}

function MouseFollowerType5(clientId, { background }) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.style.position = 'fixed';
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = 9999;
    canvas.style.mixBlendMode = 'screen';
    document.body.appendChild(canvas);

    let visible = false;

    const pos = { x: 0, y: 0 };
    const mouse = { x: 0, y: 0 };

    const getRGBA = (color, alpha) => {
        if (!color) return `rgba(0,200,255,${alpha})`;
        if (color.startsWith('rgba')) {
            return color.replace(/[\d.]+\)$/g, `${alpha})`);
        }
        if (color.startsWith('rgb')) {
            return color.replace('rgb', 'rgba').replace(/\)$/, `,${alpha})`);
        }
        const hex = color.replace('#', '');
        const bigint = parseInt(hex, 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;
        return `rgba(${r},${g},${b},${alpha})`;
    };

    const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    const render = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        pos.x += (mouse.x - pos.x) * 0.12;
        pos.y += (mouse.y - pos.y) * 0.12;

        const pulse = 18 + Math.sin(Date.now() / 200) * 2;

        ctx.beginPath();
        ctx.arc(pos.x, pos.y, pulse, 0, Math.PI * 2);
        ctx.strokeStyle = getRGBA(background, 0.25);
        ctx.lineWidth = 2.5;
        ctx.shadowBlur = 25;
        ctx.shadowColor = getRGBA(background, 0.6);
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(pos.x, pos.y, 5, 0, Math.PI * 2);
        ctx.fillStyle = getRGBA('#fff', 0.9);
        ctx.shadowBlur = 12;
        ctx.shadowColor = getRGBA(background, 1);
        ctx.fill();

        requestAnimationFrame(render);
    };
    render();

    const block = document.querySelector(`[data-block="${clientId}"]`);
    if (!block) return;

    const onMove = (e) => {
        if (!visible) return;
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    };

    const handleEnter = () => {
        visible = true;
        canvas.style.display = 'block';
    };

    const handleLeave = () => {
        visible = false;
        canvas.style.display = 'none';
    };

    document.addEventListener('mousemove', onMove);
    block.addEventListener('mouseenter', handleEnter);
    block.addEventListener('mouseleave', handleLeave);
}

function MouseFollowerType6(clientId) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.style.position = 'fixed';
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = 9999;
    canvas.style.mixBlendMode = 'screen';
    canvas.style.userSelect = 'none';
    canvas.style.display = 'none'; // initially hidden
    document.body.appendChild(canvas);

    let visible = false;
    let requestId = null;

    const mousePos = { x: 0, y: 0 };
    const trail = [];

    const maxTrail = 25;

    const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    const drawFlowerPetal = (x, y, radius, color, rotation) => {
        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(rotation);
        ctx.beginPath();
        for (let i = 0; i < 6; i++) {
            ctx.lineTo(
                Math.cos((i * Math.PI) / 3) * radius,
                Math.sin((i * Math.PI) / 3) * radius
            );
        }
        ctx.closePath();
        ctx.fillStyle = color;
        ctx.shadowColor = color;
        ctx.shadowBlur = radius * 1.5;
        ctx.fill();
        ctx.restore();
    };

    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        trail.push({
            x: mousePos.x,
            y: mousePos.y,
            alpha: 1,
            radius: 30 + Math.sin(Date.now() / 400) * 6,
            rotation: (Date.now() / 1000) % (Math.PI * 2),
            color: `hsl(${(Date.now() / 10) % 360}, 80%, 60%)`,
        });

        if (trail.length > maxTrail) {
            trail.shift();
        }

        for (let i = 0; i < trail.length; i++) {
            const t = trail[i];
            ctx.globalAlpha = t.alpha * (1 - i / maxTrail);
            drawFlowerPetal(t.x, t.y, t.radius * (1 - i / maxTrail), t.color, t.rotation);

            t.alpha -= 0.03;
            if (t.alpha < 0) t.alpha = 0;
        }
        ctx.globalAlpha = 1;

        ctx.beginPath();
        const mainRadius = 12 + Math.sin(Date.now() / 200) * 3;
        const mainColor = `hsl(${(Date.now() / 10) % 360}, 90%, 70%)`;
        ctx.arc(mousePos.x, mousePos.y, mainRadius, 0, Math.PI * 2);
        ctx.fillStyle = mainColor;
        ctx.shadowColor = mainColor;
        ctx.shadowBlur = 20;
        ctx.fill();

        requestId = requestAnimationFrame(animate);
    };

    const onMove = (e) => {
        if (!visible) return;
        mousePos.x = e.clientX;
        mousePos.y = e.clientY;
    };

    const target = document.querySelector(`[data-block="${clientId}"]`);
    if (!target) return;

    const show = () => {
        visible = true;
        trail.length = 0; // reset trail
        canvas.style.display = 'block';
        animate();
    };

    const hide = () => {
        visible = false;
        trail.length = 0;
        canvas.style.display = 'none';
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        if (requestId) {
            cancelAnimationFrame(requestId);
            requestId = null;
        }
    };

    document.addEventListener('mousemove', onMove);
    target.addEventListener('mouseenter', show);
    target.addEventListener('mouseleave', hide);

    // Return a cleanup function if you want to remove all event listeners later
    return () => {
        document.removeEventListener('mousemove', onMove);
        window.removeEventListener('resize', resize);
        target.removeEventListener('mouseenter', show);
        target.removeEventListener('mouseleave', hide);
        if (requestId) cancelAnimationFrame(requestId);
        if (canvas.parentNode) canvas.parentNode.removeChild(canvas);
    };
}

function MouseFollowerType7(clientId) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.style.position = 'fixed';
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = 9999;
    canvas.style.mixBlendMode = 'screen';
    canvas.style.userSelect = 'none';
    canvas.style.display = 'none'; // start hidden
    document.body.appendChild(canvas);

    let visible = false;
    let requestId = null;

    const mousePos = { x: 0, y: 0 };
    const particles = [];

    const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    class Particle {
        constructor(x, y) {
            this.x = x;
            this.y = y;
            this.size = Math.random() * 2 + 1;
            this.life = Math.random() * 60 + 30;
            this.alpha = 1;
            this.velocity = {
                x: (Math.random() - 0.5) * 2,
                y: (Math.random() - 0.5) * 2,
            };
            this.color = `hsl(${Math.random() * 360}, 80%, 70%)`;
        }
        update() {
            this.x += this.velocity.x;
            this.y += this.velocity.y;
            this.life--;
            this.alpha = Math.max(0, this.life / 60);
            this.size *= 0.98;
        }
        draw() {
            ctx.save();
            ctx.globalAlpha = this.alpha;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.shadowColor = this.color;
            ctx.shadowBlur = this.size * 5;
            ctx.fill();
            ctx.restore();
        }
    }

    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (visible) {
            for (let i = 0; i < 3; i++) {
                particles.push(new Particle(mousePos.x, mousePos.y));
            }
        }

        for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];
            p.update();
            if (p.life <= 0 || p.size < 0.5) {
                particles.splice(i, 1);
            } else {
                p.draw();
            }
        }

        // Show canvas only if visible or particles still exist
        canvas.style.display = visible || particles.length > 0 ? 'block' : 'none';

        requestId = requestAnimationFrame(animate);
    };

    const onMove = (e) => {
        if (!visible) return;
        mousePos.x = e.clientX;
        mousePos.y = e.clientY;
    };

    const target = document.querySelector(`[data-block="${clientId}"]`);
    if (!target) return;

    const show = () => {
        visible = true;
        particles.length = 0; // clear particles on show
    };
    const hide = () => {
        visible = false;
        // Let particles fade out naturally
    };

    document.addEventListener('mousemove', onMove);
    target.addEventListener('mouseenter', show);
    target.addEventListener('mouseleave', hide);

    animate();

    return () => {
        document.removeEventListener('mousemove', onMove);
        window.removeEventListener('resize', resize);
        target.removeEventListener('mouseenter', show);
        target.removeEventListener('mouseleave', hide);
        if (requestId) cancelAnimationFrame(requestId);
        if (canvas.parentNode) canvas.parentNode.removeChild(canvas);
    };
}

function MouseFollowerType8(clientId) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.style.position = 'fixed';
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = 9999;
    canvas.style.mixBlendMode = 'difference';
    canvas.style.userSelect = 'none';
    canvas.style.display = 'none'; // start hidden
    document.body.appendChild(canvas);

    let visible = false;
    let requestId = null;

    const mousePos = { x: 0, y: 0 };
    const glitchRects = [];

    const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    const createGlitchRect = (x, y) => ({
        x: x + (Math.random() - 0.5) * 50,
        y: y + (Math.random() - 0.5) * 50,
        width: Math.random() * 30 + 10,
        height: Math.random() * 30 + 10,
        life: 30 + Math.random() * 30,
        alpha: 1,
        color: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
    });

    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (visible) {
            if (Math.random() < 0.6) {
                glitchRects.push(createGlitchRect(mousePos.x, mousePos.y));
            }
        }

        for (let i = glitchRects.length - 1; i >= 0; i--) {
            const rect = glitchRects[i];
            rect.life--;
            rect.alpha = Math.max(0, rect.life / 60);

            ctx.globalAlpha = rect.alpha;
            ctx.fillStyle = rect.color;
            ctx.fillRect(rect.x, rect.y, rect.width, rect.height);

            if (rect.life <= 0) {
                glitchRects.splice(i, 1);
            }
        }
        ctx.globalAlpha = 1;

        if (visible) {
            const mainSize = 8 + Math.sin(Date.now() / 150) * 2;
            const mainColor = `hsl(${(Date.now() / 10) % 360}, 90%, 70%)`;
            ctx.beginPath();
            ctx.arc(mousePos.x, mousePos.y, mainSize, 0, Math.PI * 2);
            ctx.fillStyle = mainColor;
            ctx.fill();
        }

        canvas.style.display = visible || glitchRects.length > 0 ? 'block' : 'none';

        requestId = requestAnimationFrame(animate);
    };

    const onMove = (e) => {
        if (!visible) return;
        mousePos.x = e.clientX;
        mousePos.y = e.clientY;
    };

    const target = document.querySelector(`[data-block="${clientId}"]`);
    if (!target) return;

    const show = () => {
        visible = true;
        glitchRects.length = 0; // Clear glitches on show
    };
    const hide = () => {
        visible = false;
        // glitches fade out naturally
    };

    document.addEventListener('mousemove', onMove);
    target.addEventListener('mouseenter', show);
    target.addEventListener('mouseleave', hide);

    animate();

    return () => {
        document.removeEventListener('mousemove', onMove);
        window.removeEventListener('resize', resize);
        target.removeEventListener('mouseenter', show);
        target.removeEventListener('mouseleave', hide);
        if (requestId) cancelAnimationFrame(requestId);
        if (canvas.parentNode) canvas.parentNode.removeChild(canvas);
    };
}

function MouseFollowerType9(clientId) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.style.position = 'fixed';
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = 9999;
    canvas.style.mixBlendMode = 'screen';
    canvas.style.userSelect = 'none';
    canvas.style.display = 'none'; // start hidden

    document.body.appendChild(canvas);

    let visible = false;
    let requestId = null;

    const mousePos = { x: 0, y: 0 };
    const orbPos = { x: 0, y: 0 };

    const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (visible) {
            // Smoothly interpolate orb position towards mouse position
            orbPos.x += (mousePos.x - orbPos.x) * 0.15;
            orbPos.y += (mousePos.y - orbPos.y) * 0.15;

            // Draw the main orb
            const mainRadius = 25 + Math.sin(Date.now() / 300) * 5; // Pulsing effect
            const mainColor = `hsl(${(Date.now() / 20) % 360}, 70%, 50%)`;

            ctx.beginPath();
            ctx.arc(orbPos.x, orbPos.y, mainRadius, 0, Math.PI * 2);
            ctx.fillStyle = mainColor;
            ctx.shadowColor = mainColor;
            ctx.shadowBlur = mainRadius * 1.5; // Soft glow
            ctx.fill();

            // Draw subtle distortions/secondary shapes
            ctx.globalAlpha = 0.6;
            ctx.beginPath();
            ctx.arc(
                orbPos.x + Math.sin(Date.now() / 150) * 10,
                orbPos.y + Math.cos(Date.now() / 200) * 8,
                mainRadius * 0.7,
                0,
                Math.PI * 2
            );
            ctx.fillStyle = `hsl(${(Date.now() / 20 + 30) % 360}, 60%, 60%)`; // Slightly different hue
            ctx.fill();
            ctx.globalAlpha = 1;
        }

        canvas.style.display = visible ? 'block' : 'none';

        requestId = requestAnimationFrame(animate);
    };

    const onMove = (e) => {
        if (!visible) return;
        mousePos.x = e.clientX;
        mousePos.y = e.clientY;
    };

    const target = document.querySelector(`[data-block="${clientId}"]`);
    if (!target) return;

    const show = () => {
        visible = true;
        // Reset orb position on show to prevent jumping from previous state
        orbPos.x = mousePos.x;
        orbPos.y = mousePos.y;
    };

    const hide = () => {
        visible = false;
        // Orb will fade out by hiding canvas
    };

    document.addEventListener('mousemove', onMove);
    target.addEventListener('mouseenter', show);
    target.addEventListener('mouseleave', hide);

    animate();

    return () => {
        document.removeEventListener('mousemove', onMove);
        window.removeEventListener('resize', resize);
        target.removeEventListener('mouseenter', show);
        target.removeEventListener('mouseleave', hide);
        cancelAnimationFrame(requestId);
        if (canvas.parentNode) canvas.parentNode.removeChild(canvas);
    };
}

function MouseFollowerType10(clientId) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.style.position = 'fixed';
    canvas.style.top = 0;
    canvas.style.left = 0;
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = 9999;
    canvas.style.mixBlendMode = 'screen';
    canvas.style.userSelect = 'none';
    canvas.style.display = 'none';

    document.body.appendChild(canvas);

    let visible = false;
    let requestId = null;

    const mousePos = { x: 0, y: 0 };
    const blobPos = { x: 0, y: 0 };
    const ripples = [];

    const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (visible) {
            // Smoothly interpolate blob position
            blobPos.x += (mousePos.x - blobPos.x) * 0.1;
            blobPos.y += (mousePos.y - blobPos.y) * 0.1;

            // Add new ripple with some randomness
            if (Math.random() < 0.2) {
                ripples.push({
                    x: blobPos.x,
                    y: blobPos.y,
                    radius: 0,
                    alpha: 0.8,
                    color: `hsl(${(Date.now() / 30) % 360}, 70%, 70%)`
                });
            }
        }

        // Update and draw ripples
        for (let i = ripples.length - 1; i >= 0; i--) {
            const r = ripples[i];
            r.radius += 1.5;
            r.alpha -= 0.015;

            ctx.globalAlpha = Math.max(0, r.alpha);
            ctx.beginPath();
            ctx.arc(r.x, r.y, r.radius, 0, Math.PI * 2);
            ctx.strokeStyle = r.color;
            ctx.lineWidth = 2;
            ctx.shadowColor = r.color;
            ctx.shadowBlur = r.radius / 2;
            ctx.stroke();

            if (r.alpha <= 0) {
                ripples.splice(i, 1);
            }
        }
        ctx.globalAlpha = 1; // reset alpha

        // Draw main blob
        if (visible) {
            const mainRadius = 18 + Math.sin(Date.now() / 250) * 4;
            const mainColor = `hsl(${(Date.now() / 20) % 360}, 80%, 65%)`;

            ctx.beginPath();
            ctx.arc(blobPos.x, blobPos.y, mainRadius, 0, Math.PI * 2);
            ctx.fillStyle = mainColor;
            ctx.shadowColor = mainColor;
            ctx.shadowBlur = mainRadius * 2;
            ctx.fill();
        }

        // Show canvas if visible or ripples exist
        canvas.style.display = (visible || ripples.length > 0) ? 'block' : 'none';

        requestId = requestAnimationFrame(animate);
    };

    const onMove = (e) => {
        if (!visible) return;
        mousePos.x = e.clientX;
        mousePos.y = e.clientY;
    };

    const target = document.querySelector(`[data-block="${clientId}"]`);
    if (!target) return;

    const show = () => {
        visible = true;
        blobPos.x = mousePos.x;
        blobPos.y = mousePos.y;
        ripples.length = 0; // clear ripples on show
    };

    const hide = () => {
        visible = false;
        // Ripples fade out naturally
    };

    document.addEventListener('mousemove', onMove);
    target.addEventListener('mouseenter', show);
    target.addEventListener('mouseleave', hide);

    animate();

    return () => {
        document.removeEventListener('mousemove', onMove);
        window.removeEventListener('resize', resize);
        target.removeEventListener('mouseenter', show);
        target.removeEventListener('mouseleave', hide);
        cancelAnimationFrame(requestId);
        if (canvas.parentNode) canvas.parentNode.removeChild(canvas);
    };
}

function MouseFollowerType11(clientId) {
  const canvas = document.createElement('canvas');
  canvas.style.position = 'fixed';
  canvas.style.top = '0';
  canvas.style.left = '0';
  canvas.style.width = '100vw';
  canvas.style.height = '100vh';
  canvas.style.pointerEvents = 'none';
  canvas.style.zIndex = '9999';
  canvas.style.mixBlendMode = 'screen';
  canvas.style.userSelect = 'none';
  canvas.style.display = 'none';
  document.body.appendChild(canvas);

  const ctx = canvas.getContext('2d');
  const particles = [];
  let visible = false;
  let requestId;

  const mousePos = { x: 0, y: 0 };

  function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    particles.length = 0; // clear particles
  }

  resize();
  window.addEventListener('resize', resize);

  class Particle {
    constructor(x, y) {
      this.x = x;
      this.y = y;
      this.vx = (Math.random() - 0.5) * 0.5;
      this.vy = (Math.random() - 0.5) * 0.5;
      this.life = 120 + Math.random() * 60;
      this.alpha = 0;
      this.size = 2;
      this.maxDist = 100;
    }

    update() {
      this.x += this.vx;
      this.y += this.vy;
      this.life--;
      this.alpha = Math.min(1, Math.max(0, (180 - this.life) / 60));
      if (this.life < 60) this.alpha = Math.max(0, this.life / 60);
    }

    draw() {
      ctx.globalAlpha = this.alpha;
      ctx.fillStyle = `hsl(${(Date.now() / 50) % 360}, 80%, 70%)`;
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    if (visible && Math.random() < 0.8) {
      particles.push(new Particle(
        mousePos.x + (Math.random() - 0.5) * 20,
        mousePos.y + (Math.random() - 0.5) * 20
      ));
    }

    for (let i = particles.length - 1; i >= 0; i--) {
      const p = particles[i];
      p.update();

      if (p.life <= 0) {
        particles.splice(i, 1);
        continue;
      }

      p.draw();

      for (let j = i + 1; j < particles.length; j++) {
        const p2 = particles[j];
        const dist = Math.hypot(p.x - p2.x, p.y - p2.y);
        if (dist < p.maxDist) {
          ctx.globalAlpha = p.alpha * p2.alpha * (1 - dist / p.maxDist) * 0.5;
          ctx.strokeStyle = `hsl(${(Date.now() / 50) % 360}, 80%, 70%)`;
          ctx.lineWidth = 1;
          ctx.beginPath();
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(p2.x, p2.y);
          ctx.stroke();
        }
      }
    }

    ctx.globalAlpha = 1;
    canvas.style.display = visible || particles.length > 0 ? 'block' : 'none';
    requestId = requestAnimationFrame(animate);
  }

  function onMouseMove(e) {
    if (!visible) return;
    mousePos.x = e.clientX;
    mousePos.y = e.clientY;
  }

  const target = document.querySelector(`[data-block="${clientId}"]`);
  if (!target) return;

  const show = () => {
    visible = true;
    particles.length = 0;
  };

  const hide = () => {
    visible = false;
  };

  document.addEventListener('mousemove', onMouseMove);
  target.addEventListener('mouseenter', show);
  target.addEventListener('mouseleave', hide);

  animate();

  // Cleanup (optional, if you want to manually destroy)
  return () => {
    document.removeEventListener('mousemove', onMouseMove);
    window.removeEventListener('resize', resize);
    target.removeEventListener('mouseenter', show);
    target.removeEventListener('mouseleave', hide);
    cancelAnimationFrame(requestId);
    canvas.remove();
  };
}

const mouseFollowers = {
  MouseFollowerType1,
  MouseFollowerType2,
  MouseFollowerType3,
  MouseFollowerType4,
  MouseFollowerType5,
  MouseFollowerType6,
  MouseFollowerType7,
  MouseFollowerType8,
  MouseFollowerType9,
  MouseFollowerType10,
  MouseFollowerType11,
};

// 🔧 Main initializer
export function initMouseFollowers() {
  document.querySelectorAll('[data-block]').forEach((el) => {
    const clientId = el.getAttribute('data-block');
    const type = el.dataset.followerType;

    if (!type || type=== 'none') return;

    const options = {
      background: el.dataset.followerBackground || '',
      size: parseFloat(el.dataset.followerSize) || 0,
      decay: parseFloat(el.dataset.followerDecay) || 0,
    };

    const followerFunc = mouseFollowers[type];
    if (typeof followerFunc === 'function') {
      followerFunc(clientId, options);
    }
  });
}
