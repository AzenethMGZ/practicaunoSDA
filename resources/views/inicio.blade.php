<div class="fondo" style="width: 100%; height: 300px; background-image: url('game_background.jpg'); background-size: cover; background-position: center;">
    <div class="texto">
        <p>¡Bienvenido a los Videojuegos!</p>
    </div>
</div>

<div class="game-info">
    <h1>¿Qué es GameZone?</h1>
    <p>GameZone es un lugar donde puedes disfrutar de los mejores juegos y conectarte con la comunidad gamer.</p>
</div>

<!-- Sección de contenido simplificada sin las cards -->
<div class="simple-container">
    <div class="row">
        <p>Explora nuestros increíbles juegos y contenido exclusivo para gamers.</p>
    </div>
</div>

<!-- Botón de Cerrar Sesión -->
<div class="logout-btn">
    <!-- Formulario de Cerrar Sesión -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf  
        <button type="submit">Cerrar Sesión</button>
    </form>
</div>

<style>
    .fondo {
        width: 100%;
        height: 300px;
        background-size: cover;
        background-position: center;
        position: relative;
        background-color: #1a2b4c; /* Fondo oscuro azul */
    }

    .texto {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: #ffffff;
        font-size: 1.5em;
        font-family: Arial, sans-serif;
    }

    .game-info h1 {
        text-align: center;
        color: #4f9bd3; /* Azul claro */
    }

    .simple-container {
        padding: 20px;
        text-align: center;
    }

    .row p {
        font-size: 1.2em;
        color: #333;
    }

    .logout-btn {
        position: fixed;
        top: 20px;
        right: 20px;
    }

    .logout-btn button {
        background-color: #0066cc; /* Azul oscuro */
        color: white;
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .logout-btn button:hover {
        background-color: #004a99; /* Azul más oscuro al pasar el ratón */
    }
</style>
