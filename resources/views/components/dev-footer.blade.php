{{-- Developer Credits Footer Component --}}
{{-- Usage: @include('components.dev-footer') --}}

<footer class="dev-footer">
    <div class="dev-badge">
        <span class="dev-label" data-en="Designed & Developed By" data-ar="تصميم وتطوير">Designed & Developed By</span>
        <div class="dev-details">
            <span class="dev-name" data-en="Mohammed Sadeq Zuhair" data-ar="محمد صادق زهير">Mohammed Sadeq Zuhair</span>
            <div class="social-divider"></div>
            <a href="https://instagram.com/0_9vz" target="_blank" rel="noopener" class="social-link" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.linkedin.com/in/mohammed-sadeq-zuhair-sadeq-1aa6112b7/" target="_blank" rel="noopener" class="social-link" aria-label="LinkedIn">
                <i class="fab fa-linkedin"></i>
            </a>
        </div>
    </div>
</footer>

<style>
    .dev-footer {
        padding: 2rem;
        margin-top: auto;
        text-align: center;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(10px);
    }
    
    .dev-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    
    .dev-label {
        font-size: 0.7rem;
        color: #A3A3A3;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    
    .dev-details {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.5rem 1.5rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
    }
    
    .dev-details:hover {
        border-color: #D4AF37;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
    }
    
    .dev-name {
        font-weight: 700;
        color: #fff;
        font-size: 0.9rem;
    }
    
    .social-divider {
        width: 1px;
        height: 15px;
        background: rgba(255, 255, 255, 0.08);
    }
    
    .social-link {
        color: #A3A3A3;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .social-link:hover {
        color: #fff;
        transform: scale(1.2);
    }
    
    @media (max-width: 768px) {
        .dev-details {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
    }
</style>
