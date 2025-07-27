// Script para manejar el botón de like (esta parte del codigo nos ayudo la IA)
//Nos ayudo con la idea de no solo poner like sino quitarlo y solo los UR puedan dar like
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            fetch('php/like.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id_carta=' + encodeURIComponent(id)
            })
            .then(res => res.text())
            .then(data => {
                if(data === 'login') {
                    alert('Debes iniciar sesión para dar like.');
                } else if(data === 'liked') {
                    this.textContent = '💖 Liked';
                } else if(data === 'unliked') {
                    this.textContent = '❤️ Like';
                }
            }.bind(this));
        });
    });
});

// Script para mostrar/ocultar contraseña (esta idea de mostrar contraseña salio de una clase de APPWEB :3)
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtns = document.querySelectorAll('.toggle-password');
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('data-target'));
            if (input.type === "password") {
                input.type = "text";
                this.textContent = "Ocultar";
            } else {
                input.type = "password";
                this.textContent = "Mostrar";
            }
        });
    });
});