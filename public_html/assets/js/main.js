// Notifiche toast base
function showToast(msg, type = 'info') {
    let toast = document.createElement('div');
    toast.className = 'toast ' + type;
    toast.textContent = msg;
    Object.assign(toast.style, {
        position: 'fixed', bottom: '32px', left: '50%', transform: 'translateX(-50%)',
        background: type==='success' ? '#30D158' : (type==='error' ? '#FF453A' : '#007AFF'),
        color: '#fff', padding: '14px 32px', borderRadius: '24px', fontWeight: '600', fontSize: '1.1rem',
        zIndex: 9999, boxShadow: '0 4px 20px rgba(0,0,0,0.2)', opacity: 0.95
    });
    document.body.appendChild(toast);
    setTimeout(()=>{ toast.remove(); }, 3500);
}

// Conferma azioni critiche
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[data-confirm]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            if(!confirm(link.getAttribute('data-confirm'))) e.preventDefault();
        });
    });
    // Lazy loading immagini con effetto blur
    document.querySelectorAll('img[loading="lazy"]').forEach(function(img){
        img.addEventListener('load',function(){img.classList.add('loaded');});
        if(img.complete) img.classList.add('loaded');
    });
    // Focus automatico primo input form
    let firstInput = document.querySelector('form input, form select');
    if(firstInput) firstInput.focus();
    // Stelle animate background
    if(!document.querySelector('.stars')){
        let stars = document.createElement('canvas');
        stars.className = 'stars';
        document.body.appendChild(stars);
        let ctx = stars.getContext('2d');
        let w = window.innerWidth, h = window.innerHeight;
        stars.width = w; stars.height = h;
        let n = Math.floor(w*h/2500), arr = [];
        for(let i=0;i<n;i++) arr.push({x:Math.random()*w,y:Math.random()*h,r:Math.random()*1.2+0.2,a:Math.random()*2*Math.PI,s:Math.random()*0.5+0.2});
        function draw(){
            ctx.clearRect(0,0,w,h);
            for(let s of arr){
                ctx.save();
                ctx.globalAlpha = 0.7+0.3*Math.sin(Date.now()/800+s.a);
                ctx.beginPath();
                ctx.arc(s.x,s.y,s.r,0,2*Math.PI);
                ctx.fillStyle = '#fff';
                ctx.shadowColor = '#fff';
                ctx.shadowBlur = 8;
                ctx.fill();
                ctx.restore();
            }
        }
        setInterval(draw, 60);
        window.addEventListener('resize',()=>{
            w = window.innerWidth; h = window.innerHeight;
            stars.width = w; stars.height = h;
        });
    }
}); 