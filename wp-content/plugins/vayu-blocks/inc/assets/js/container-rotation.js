export function containerRotation() {
    const vbParents = document.querySelectorAll('.vb_marqee_slide');
    if (!vbParents.length) return; // Exit if no elements found

    vbParents.forEach(vbParent => {
        const vbWrap = vbParent.querySelector('[data-vayu-marquee]');
        if (!vbWrap) return; // Skip if no valid child element

        // Ensure exactly two clones
        if (!vbWrap.classList.contains('cloned')) {
            vbWrap.innerHTML = vbWrap.innerHTML + vbWrap.innerHTML + vbWrap.innerHTML; // Original + 2 clones
            vbWrap.classList.add('cloned');
        }

        // Get user config from data attributes
        const speed = parseFloat(vbWrap.dataset.speed) || 1; // pixels per frame
        const direction = vbWrap.dataset.direction || 'right-to-left';
        const stophover = vbWrap.dataset.stophover === 'true';

        const totalWidth = vbWrap.scrollWidth / 3; // Since we have original + 2 clones

        let transformX = 0;
        let isPaused = false;

        // Add CSS for smooth transition
        vbWrap.style.willChange = 'transform';
        vbWrap.style.transition = 'transform 0.016s linear'; // 60fps = ~16ms per frame

        function animate() {
            if (isPaused) {
                requestAnimationFrame(animate);
                return;
            }

            if (direction === 'right-to-left') {
                transformX -= speed;
                if (Math.abs(transformX) >= totalWidth) {
                    transformX = 0;
                    vbWrap.style.transition = 'none'; // Disable transition for reset
                    vbWrap.style.transform = `translateX(0px)`;
                    requestAnimationFrame(() => {
                        vbWrap.style.transition = 'transform 0.016s linear'; // Re-enable
                    });
                }
            } else if (direction === 'left-to-right') {
                transformX += speed;
                if (transformX >= 0) { // Reset when reaching start of original content
                    transformX = -totalWidth; // Jump to end of first clone
                    vbWrap.style.transition = 'none'; // Disable transition for reset
                    vbWrap.style.transform = `translateX(${-totalWidth}px)`;
                    requestAnimationFrame(() => {
                        vbWrap.style.transition = 'transform 0.016s linear'; // Re-enable
                    });
                }
            }

            vbWrap.style.transform = `translateX(${transformX}px)`;
            requestAnimationFrame(animate);
        }

        animate();

        // Pause on hover (optional)
        if (stophover) {
            vbWrap.addEventListener('mouseenter', () => { isPaused = true; });
            vbWrap.addEventListener('mouseleave', () => { isPaused = false; });
        }
    });
}