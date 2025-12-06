/**
 * Sistem Animasi Canggih - Sistem Pelayanan Masyarakat Kembangan Raya
 *
 * Animasi JavaScript yang memberikan pengalaman user yang luar biasa dengan:
 * - Animasi halaman saat load
 * - Animasi scroll dengan Intersection Observer
 * - Efek hover yang smooth
 * - Animasi loading dan progress
 * - Micro-interactions
 * - Particle effects
 * - Smooth scrolling
 * - Parallax effects
 */

class AnimationSystem {
    constructor() {
        this.init();
        this.bindEvents();
    }

    /**
     * Inisialisasi sistem animasi
     */
    init() {
        this.setupPageLoadAnimations();
        this.setupScrollAnimations();
        this.setupHoverEffects();
        this.setupLoadingAnimations();
        this.setupParticleEffects();
        this.setupMicroInteractions();
    }

    /**
     * Setup animasi saat halaman dimuat
     */
    setupPageLoadAnimations() {
        // Animasi hero section
        const heroElements = document.querySelectorAll('.hero-section *');
        heroElements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';

            setTimeout(() => {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Animasi cards dengan stagger effect
        const cards = document.querySelectorAll('.card');
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0) scale(1)';
                    }, index * 150);
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px) scale(0.95)';
            card.style.transition = 'all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            cardObserver.observe(card);
        });

        // Animasi navbar
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            navbar.style.transform = 'translateY(-100%)';
            navbar.style.transition = 'transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';

            setTimeout(() => {
                navbar.style.transform = 'translateY(0)';
            }, 200);
        }
    }

    /**
     * Setup animasi scroll dengan Intersection Observer
     */
    setupScrollAnimations() {
        // Animasi fade in dari kiri/kanan
        const fadeElements = document.querySelectorAll('.fade-in-left, .fade-in-right, .fade-in-up, .fade-in-down');

        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const direction = element.classList.contains('fade-in-left') ? 'left' :
                                    element.classList.contains('fade-in-right') ? 'right' :
                                    element.classList.contains('fade-in-up') ? 'up' : 'down';

                    element.style.opacity = '1';
                    element.style.transform = 'translate(0, 0) scale(1)';
                    element.classList.add('animated');
                }
            });
        }, {
            threshold: 0.2,
            rootMargin: '0px 0px -50px 0px'
        });

        fadeElements.forEach(element => {
            const direction = element.classList.contains('fade-in-left') ? 'left' :
                            element.classList.contains('fade-in-right') ? 'right' :
                            element.classList.contains('fade-in-up') ? 'up' : 'down';

            const transform = direction === 'left' ? 'translateX(-50px)' :
                            direction === 'right' ? 'translateX(50px)' :
                            direction === 'up' ? 'translateY(50px)' : 'translateY(-50px)';

            element.style.opacity = '0';
            element.style.transform = transform + ' scale(0.95)';
            element.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';

            fadeObserver.observe(element);
        });

        // Animasi counter/statistics
        const counters = document.querySelectorAll('.counter');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                    this.animateCounter(entry.target);
                    entry.target.classList.add('counted');
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => counterObserver.observe(counter));

        // Parallax effect untuk background
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.parallax-bg');

            parallaxElements.forEach(element => {
                const rate = element.dataset.parallax || 0.5;
                element.style.transform = `translateY(${scrolled * rate}px)`;
            });
        });
    }

    /**
     * Animasi counter untuk statistik
     */
    animateCounter(element) {
        const target = parseInt(element.dataset.target || element.textContent.replace(/\D/g, ''));
        const duration = parseInt(element.dataset.duration || 2000);
        const start = Date.now();
        const startValue = 0;

        const animate = () => {
            const elapsed = Date.now() - start;
            const progress = Math.min(elapsed / duration, 1);

            // Easing function
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const current = Math.floor(startValue + (target - startValue) * easeOutQuart);

            element.textContent = current.toLocaleString();

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };

        animate();
    }

    /**
     * Setup efek hover yang smooth
     */
    setupHoverEffects() {
        // Enhanced card hover effects
        const enhancedCards = document.querySelectorAll('.card-hover-enhanced');

        enhancedCards.forEach(card => {
            card.addEventListener('mouseenter', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);

                card.classList.add('hover-active');
            });

            card.addEventListener('mouseleave', () => {
                card.classList.remove('hover-active');
            });

            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            });
        });

        // Button hover effects
        const buttons = document.querySelectorAll('.btn-animated');

        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.classList.add('pulse');
            });

            button.addEventListener('mouseleave', () => {
                button.classList.remove('pulse');
            });

            button.addEventListener('click', () => {
                button.classList.add('clicked');
                setTimeout(() => button.classList.remove('clicked'), 300);
            });
        });

        // Form input focus effects
        const formInputs = document.querySelectorAll('.form-control-animated');

        formInputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', () => {
                if (!input.value) {
                    input.parentElement.classList.remove('focused');
                }
            });
        });
    }

    /**
     * Setup animasi loading
     */
    setupLoadingAnimations() {
        // Loading spinner untuk form submissions
        const forms = document.querySelectorAll('form');

        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"]');

                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;

                    submitBtn.innerHTML = `
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Memproses...
                    `;

                    // Reset after 10 seconds (fallback)
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 10000);
                }
            });
        });

        // Loading animation untuk lazy images
        const lazyImages = document.querySelectorAll('img[data-src]');

        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('loading');

                    const newImg = new Image();
                    newImg.onload = () => {
                        img.src = img.dataset.src;
                        img.classList.remove('loading');
                        img.classList.add('loaded');
                    };
                    newImg.src = img.dataset.src;

                    imageObserver.unobserve(img);
                }
            });
        }, { rootMargin: '50px' });

        lazyImages.forEach(img => imageObserver.observe(img));
    }

    /**
     * Setup efek partikel
     */
    setupParticleEffects() {
        // Particle effect untuk hero section
        const heroSection = document.querySelector('.hero-section');

        if (heroSection) {
            this.createParticleSystem(heroSection);
        }

        // Floating elements animation
        const floatingElements = document.querySelectorAll('.floating-element');

        floatingElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.5}s`;
            element.classList.add('floating');
        });
    }

    /**
     * Membuat sistem partikel
     */
    createParticleSystem(container) {
        const particleCount = 50;
        const particles = [];

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.cssText = `
                position: absolute;
                width: ${Math.random() * 4 + 1}px;
                height: ${Math.random() * 4 + 1}px;
                background: rgba(255, 255, 255, ${Math.random() * 0.3 + 0.1});
                border-radius: 50%;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                animation: float ${Math.random() * 10 + 10}s linear infinite;
                pointer-events: none;
            `;

            container.appendChild(particle);
            particles.push(particle);
        }

        // Add keyframes for floating animation
        if (!document.querySelector('#particle-styles')) {
            const style = document.createElement('style');
            style.id = 'particle-styles';
            style.textContent = `
                @keyframes float {
                    0% { transform: translateY(0px) rotate(0deg); }
                    50% { transform: translateY(-20px) rotate(180deg); }
                    100% { transform: translateY(0px) rotate(360deg); }
                }

                .floating {
                    animation: floating 6s ease-in-out infinite;
                }

                @keyframes floating {
                    0%, 100% { transform: translateY(0px); }
                    50% { transform: translateY(-10px); }
                }
            `;
            document.head.appendChild(style);
        }
    }

    /**
     * Setup micro-interactions
     */
    setupMicroInteractions() {
        // Success/error message animations
        const alerts = document.querySelectorAll('.alert');

        alerts.forEach(alert => {
            alert.style.animation = 'slideInRight 0.5s ease-out';

            const closeBtn = alert.querySelector('.btn-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    alert.style.animation = 'slideOutRight 0.3s ease-in forwards';
                    setTimeout(() => alert.remove(), 300);
                });
            }
        });

        // Progress bar animations
        const progressBars = document.querySelectorAll('.progress-bar');

        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            bar.style.transition = 'width 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)';

            setTimeout(() => {
                bar.style.width = width;
            }, 500);
        });

        // Tab switching animations
        const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');

        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', (e) => {
                const target = document.querySelector(e.target.getAttribute('data-bs-target'));
                if (target) {
                    target.style.animation = 'fadeIn 0.3s ease-in';
                }
            });
        });

        // Tooltip animations
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // Toast animations
        const toasts = document.querySelectorAll('.toast');

        toasts.forEach(toast => {
            toast.style.animation = 'slideInUp 0.5s ease-out';
        });
    }

    /**
     * Smooth scrolling untuk anchor links
     */
    setupSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));

                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.offsetTop;
                    const offsetPosition = elementPosition - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Bind semua event listeners
     */
    bindEvents() {
        // Smooth scrolling
        this.setupSmoothScrolling();

        // Window resize handling
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.handleResize();
            }, 250);
        });

        // Page visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                // Pause animations when tab is not visible
                document.documentElement.style.setProperty('--animation-play-state', 'paused');
            } else {
                // Resume animations when tab becomes visible
                document.documentElement.style.setProperty('--animation-play-state', 'running');
            }
        });
    }

    /**
     * Handle window resize
     */
    handleResize() {
        // Recalculate positions for animations if needed
        const particles = document.querySelectorAll('.particle');
        particles.forEach(particle => {
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
        });
    }

    /**
     * Utility method untuk menambahkan animasi custom
     */
    static addAnimation(element, animationName, duration = 0.5) {
        element.style.animation = `${animationName} ${duration}s ease-out`;
        element.addEventListener('animationend', () => {
            element.style.animation = '';
        }, { once: true });
    }

    /**
     * Utility method untuk membuat ripple effect
     */
    static createRippleEffect(event) {
        const button = event.currentTarget;
        const circle = document.createElement('span');
        const diameter = Math.max(button.clientWidth, button.clientHeight);
        const radius = diameter / 2;

        const rect = button.getBoundingClientRect();
        circle.style.width = circle.style.height = `${diameter}px`;
        circle.style.left = `${event.clientX - rect.left - radius}px`;
        circle.style.top = `${event.clientY - rect.top - radius}px`;
        circle.classList.add('ripple-effect');

        const ripple = button.querySelector('.ripple-effect');
        if (ripple) {
            ripple.remove();
        }

        button.appendChild(circle);

        setTimeout(() => circle.remove(), 600);
    }
}

// Initialize animation system when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new AnimationSystem();
});

// Add CSS animations
const animationStyles = `
<style>
/* Enhanced animations */
@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideOutRight {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}

@keyframes slideInUp {
    from { transform: translateY(100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Button animations */
.btn-animated {
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.btn-animated.pulse {
    animation: pulse 0.6s infinite;
}

.btn-animated.clicked {
    animation: shake 0.5s ease-in-out;
}

/* Ripple effect */
.ripple-effect {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple 0.6s linear;
    pointer-events: none;
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

/* Form animations */
.form-control-animated {
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.form-control-animated:focus {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
}

/* Enhanced card hover */
.card-hover-enhanced {
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.card-hover-enhanced::before {
    content: '';
    position: absolute;
    top: var(--mouse-y, 50%);
    left: var(--mouse-x, 50%);
    width: 0;
    height: 0;
    background: radial-gradient(circle, rgba(0,123,255,0.1) 0%, transparent 70%);
    transition: width 0.6s, height 0.6s;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    pointer-events: none;
}

.card-hover-enhanced.hover-active::before {
    width: 300px;
    height: 300px;
}

/* Loading states */
.loading {
    position: relative;
    overflow: hidden;
}

.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Success animations */
@keyframes successPulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(25, 135, 84, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
}

.success-animation {
    animation: successPulse 0.6s ease-out;
}

/* Error animations */
@keyframes errorShake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.error-animation {
    animation: errorShake 0.5s ease-in-out;
}

/* Notification badge animations */
@keyframes notificationPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.notification-badge {
    animation: notificationPulse 2s infinite;
}

/* Scroll indicator */
.scroll-indicator {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    transform: translateY(100px);
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    z-index: 1000;
}

.scroll-indicator.visible {
    opacity: 1;
    transform: translateY(0);
}

.scroll-indicator:hover {
    transform: translateY(-5px) scale(1.1);
}

/* Performance optimizations */
* {
    animation-play-state: var(--animation-play-state, running);
}
</style>
`;

// Inject styles into head
document.head.insertAdjacentHTML('beforeend', animationStyles);

// Add scroll indicator
const scrollIndicator = document.createElement('div');
scrollIndicator.className = 'scroll-indicator';
scrollIndicator.innerHTML = '<i class="bi bi-chevron-up text-white fs-5"></i>';
scrollIndicator.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });
document.body.appendChild(scrollIndicator);

// Show/hide scroll indicator
window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollIndicator.classList.add('visible');
    } else {
        scrollIndicator.classList.remove('visible');
    }
});

/**
 * Utility functions untuk animasi
 */
window.AnimationUtils = {
    // Create floating animation for elements
    makeFloat(selector, duration = 6) {
        const elements = document.querySelectorAll(selector);
        elements.forEach((element, index) => {
            element.style.animation = `floating ${duration}s ease-in-out infinite`;
            element.style.animationDelay = `${index * 0.5}s`;
        });
    },

    // Add stagger animation to elements
    staggerAnimation(selector, animation = 'fadeInUp', delay = 100) {
        const elements = document.querySelectorAll(selector);
        elements.forEach((element, index) => {
            setTimeout(() => {
                element.style.animation = `${animation} 0.6s ease-out forwards`;
            }, index * delay);
        });
    },

    // Create typing effect for text
    typeWriter(element, text, speed = 50) {
        let i = 0;
        element.textContent = '';

        const timer = setInterval(() => {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
            } else {
                clearInterval(timer);
            }
        }, speed);
    },

    // Create confetti effect
    createConfetti() {
        const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#f9ca24', '#f0932b', '#eb4d4b'];

        for (let i = 0; i < 100; i++) {
            const confetti = document.createElement('div');
            confetti.style.cssText = `
                position: fixed;
                width: 8px;
                height: 8px;
                background: ${colors[Math.floor(Math.random() * colors.length)]};
                top: -10px;
                left: ${Math.random() * 100}vw;
                z-index: 9999;
                animation: confetti ${Math.random() * 3 + 2}s linear forwards;
                transform: rotate(${Math.random() * 360}deg);
            `;

            document.body.appendChild(confetti);

            setTimeout(() => confetti.remove(), 5000);
        }

        // Add confetti keyframes
        if (!document.querySelector('#confetti-styles')) {
            const style = document.createElement('style');
            style.id = 'confetti-styles';
            style.textContent = `
                @keyframes confetti {
                    0% { transform: translateY(-10px) rotate(0deg); }
                    100% { transform: translateY(100vh) rotate(720deg); }
                }
            `;
            document.head.appendChild(style);
        }
    }
};

// Export for global use
window.AnimationSystem = AnimationSystem;
