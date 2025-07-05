/**
 * AstroGuida Stellar Animations
 * Gestione animazioni stellari e interazioni UI
 */

class StellarAnimations {
    constructor() {
        this.init();
        this.createStars();
        this.createParticles();
        this.createMeteors();
        this.setupScrollAnimations();
        this.setupInteractions();
    }

    init() {
        // Crea il container per lo sfondo stellare
        if (!document.querySelector('.stellar-background')) {
            const stellarBg = document.createElement('div');
            stellarBg.className = 'stellar-background';
            
            // Aggiungi nebulosa
            const nebula = document.createElement('div');
            nebula.className = 'nebula';
            stellarBg.appendChild(nebula);
            
            // Aggiungi aurora
            const aurora = document.createElement('div');
            aurora.className = 'aurora';
            stellarBg.appendChild(aurora);
            
            // Aggiungi container stelle
            const starsContainer = document.createElement('div');
            starsContainer.className = 'stars';
            stellarBg.appendChild(starsContainer);
            
            // Aggiungi container particelle
            const particlesContainer = document.createElement('div');
            particlesContainer.className = 'particles';
            stellarBg.appendChild(particlesContainer);
            
            // Aggiungi pianeti
            this.createPlanets(stellarBg);
            
            document.body.insertBefore(stellarBg, document.body.firstChild);
        }
    }

    createStars() {
        const starsContainer = document.querySelector('.stars');
        if (!starsContainer) return;

        const starCount = 150;
        
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.className = this.getStarClass();
            
            // Posizionamento casuale
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            
            // Animazione casuale
            star.style.animationDelay = Math.random() * 3 + 's';
            star.style.animationDuration = (2 + Math.random() * 3) + 's';
            
            starsContainer.appendChild(star);
        }
    }

    getStarClass() {
        const classes = ['star star-small', 'star star-medium', 'star star-large'];
        const colors = ['', 'star-blue', 'star-purple', 'star-cyan'];
        
        const baseClass = classes[Math.floor(Math.random() * classes.length)];
        const colorClass = colors[Math.floor(Math.random() * colors.length)];
        
        return baseClass + (colorClass ? ' ' + colorClass : '');
    }

    createParticles() {
        const particlesContainer = document.querySelector('.particles');
        if (!particlesContainer) return;

        const particleCount = 20;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            // Posizionamento e timing casuali
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 20 + 's';
            particle.style.animationDuration = (10 + Math.random() * 15) + 's';
            
            particlesContainer.appendChild(particle);
        }
    }

    createMeteors() {
        const stellarBg = document.querySelector('.stellar-background');
        if (!stellarBg) return;

        // Crea meteore periodicamente
        setInterval(() => {
            if (Math.random() < 0.3) { // 30% di probabilità
                this.createSingleMeteor(stellarBg);
            }
        }, 5000); // Ogni 5 secondi
    }

    createSingleMeteor(container) {
        const meteor = document.createElement('div');
        meteor.className = 'meteor';
        
        // Posizione di partenza casuale
        meteor.style.top = Math.random() * 50 + '%';
        meteor.style.left = Math.random() * 100 + '%';
        
        container.appendChild(meteor);
        
        // Rimuovi dopo l'animazione
        setTimeout(() => {
            if (meteor.parentNode) {
                meteor.parentNode.removeChild(meteor);
            }
        }, 3000);
    }

    createPlanets(container) {
        const planetSmall = document.createElement('div');
        planetSmall.className = 'planet planet-small';
        container.appendChild(planetSmall);
        
        const planetMedium = document.createElement('div');
        planetMedium.className = 'planet planet-medium';
        container.appendChild(planetMedium);
    }

    setupScrollAnimations() {
        // Intersection Observer per animazioni scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeIn');
                }
            });
        }, observerOptions);

        // Osserva elementi con animazioni
        const animatedElements = document.querySelectorAll(
            '.card, .service-card, .gallery-item, .section-header'
        );
        
        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }

    setupInteractions() {
        this.setupCardHovers();
        this.setupButtonEffects();
        this.setupParallaxEffect();
        this.setupMouseTracker();
    }

    setupCardHovers() {
        const cards = document.querySelectorAll('.card, .service-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
                card.style.boxShadow = '0 20px 40px rgba(100, 255, 218, 0.2)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
                card.style.boxShadow = '';
            });
        });
    }

    setupButtonEffects() {
        const buttons = document.querySelectorAll('.btn');
        
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                // Effetto ripple
                const ripple = document.createElement('span');
                ripple.className = 'ripple-effect';
                
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                button.appendChild(ripple);
                
                setTimeout(() => {
                    if (ripple.parentNode) {
                        ripple.parentNode.removeChild(ripple);
                    }
                }, 600);
            });
        });
    }

    setupParallaxEffect() {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.nebula, .aurora');
            
            parallaxElements.forEach(element => {
                const speed = 0.5;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    }

    setupMouseTracker() {
        let mouseX = 0;
        let mouseY = 0;
        
        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX / window.innerWidth;
            mouseY = e.clientY / window.innerHeight;
            
            // Effetto parallax leggero per le stelle
            const stars = document.querySelectorAll('.star');
            stars.forEach((star, index) => {
                const speed = (index % 3 + 1) * 0.5;
                const x = (mouseX - 0.5) * speed;
                const y = (mouseY - 0.5) * speed;
                
                star.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    }

    // Metodi pubblici per controllo animazioni
    pauseAnimations() {
        const stellarBg = document.querySelector('.stellar-background');
        if (stellarBg) {
            stellarBg.style.animationPlayState = 'paused';
            stellarBg.querySelectorAll('*').forEach(el => {
                el.style.animationPlayState = 'paused';
            });
        }
    }

    resumeAnimations() {
        const stellarBg = document.querySelector('.stellar-background');
        if (stellarBg) {
            stellarBg.style.animationPlayState = 'running';
            stellarBg.querySelectorAll('*').forEach(el => {
                el.style.animationPlayState = 'running';
            });
        }
    }

    toggleAnimations() {
        const stellarBg = document.querySelector('.stellar-background');
        if (!stellarBg) return;
        
        const currentState = stellarBg.style.animationPlayState;
        if (currentState === 'paused') {
            this.resumeAnimations();
        } else {
            this.pauseAnimations();
        }
    }
}

// Utility per effetti CSS dinamici
class StellarEffects {
    static addGlow(element, color = '100, 255, 218') {
        element.style.boxShadow = `0 0 20px rgba(${color}, 0.5)`;
        element.style.animation = 'stellar-pulse 2s infinite';
    }

    static removeGlow(element) {
        element.style.boxShadow = '';
        element.style.animation = '';
    }

    static addCosmicBorder(element) {
        element.classList.add('cosmic-border');
    }

    static createFloatingText(text, x, y) {
        const floatingText = document.createElement('div');
        floatingText.textContent = text;
        floatingText.style.cssText = `
            position: fixed;
            left: ${x}px;
            top: ${y}px;
            color: var(--cyan-bright);
            font-weight: bold;
            pointer-events: none;
            z-index: 9999;
            animation: floatUp 2s ease-out forwards;
        `;
        
        document.body.appendChild(floatingText);
        
        setTimeout(() => {
            if (floatingText.parentNode) {
                floatingText.parentNode.removeChild(floatingText);
            }
        }, 2000);
    }

    static rippleEffect(element, event) {
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        const ripple = document.createElement('div');
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: radial-gradient(circle, rgba(100, 255, 218, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        `;
        
        element.style.position = 'relative';
        element.style.overflow = 'hidden';
        element.appendChild(ripple);
        
        setTimeout(() => {
            if (ripple.parentNode) {
                ripple.parentNode.removeChild(ripple);
            }
        }, 600);
    }
}

// Aggiungi CSS per animazioni dinamiche
const dynamicStyles = `
    @keyframes floatUp {
        0% {
            opacity: 1;
            transform: translateY(0);
        }
        100% {
            opacity: 0;
            transform: translateY(-50px);
        }
    }
    
    @keyframes ripple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(2);
            opacity: 0;
        }
    }
    
    .ripple-effect {
        position: absolute;
        background: radial-gradient(circle, rgba(100, 255, 218, 0.3) 0%, transparent 70%);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s ease-out;
        pointer-events: none;
    }
`;

// Aggiungi gli stili al documento
const styleSheet = document.createElement('style');
styleSheet.textContent = dynamicStyles;
document.head.appendChild(styleSheet);

// Inizializzazione automatica quando il DOM è pronto
document.addEventListener('DOMContentLoaded', () => {
    window.stellarAnimations = new StellarAnimations();
    window.StellarEffects = StellarEffects;
    
    // Controlla preferenze utente per animazioni ridotte
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        window.stellarAnimations.pauseAnimations();
    }
});

// Esporta per uso modulare
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { StellarAnimations, StellarEffects };
} 