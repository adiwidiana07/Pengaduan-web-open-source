document.addEventListener('DOMContentLoaded', function () {

    // ======================== AUTO-DISMISS FLASH MESSAGES ========================
    document.querySelectorAll('[data-flash]').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-10px)';
            setTimeout(function () { el.remove(); }, 600);
        }, 4000);
    });

    // ======================== ENHANCED CLIPBOARD ========================
    document.querySelectorAll('[data-clipboard]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var text = btn.getAttribute('data-clipboard');
            navigator.clipboard.writeText(text).then(function () {
                var original = btn.innerHTML;
                btn.innerHTML = '<span class="text-emerald-600">&#10003; Tersalin!</span>';
                setTimeout(function () { btn.innerHTML = original; }, 2000);
            });
        });
    });

    // ======================== CONFIRM DIALOGS ========================
    document.querySelectorAll('[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            var message = form.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // ======================== TOGGLE PASSWORD VISIBILITY ========================
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.getElementById(btn.getAttribute('data-toggle-password'));
            if (target) {
                var type = target.getAttribute('type') === 'password' ? 'text' : 'password';
                target.setAttribute('type', type);
                btn.innerHTML = type === 'password' ? '&#128065;' : '&#128064;';
            }
        });
    });

    // ======================== FORM LOADING STATES ========================
    document.querySelectorAll('form[data-loading]').forEach(function (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.dataset.originalText = btn.innerHTML;
                btn.innerHTML = '<svg class="inline w-4 h-4 animate-spin -ml-1 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg> Memproses...';
            }
        });
    });

    // ======================== ACTIVE NAV LINK ========================
    var currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(function (link) {
        var href = link.getAttribute('href');
        if (href && currentPath === href) {
            link.classList.add('text-indigo-600', 'font-semibold');
            link.classList.remove('text-gray-500');
        }
    });

    // ======================== TEXTAREA AUTO-RESIZE ========================
    document.querySelectorAll('textarea[data-auto-resize]').forEach(function (textarea) {
        textarea.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });

});
