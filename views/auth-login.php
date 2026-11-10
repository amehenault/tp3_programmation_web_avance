{% extends 'layout.php' %}

{% block content %}

<section class="form-shell">
    <h1>
        Connexion
    </h1>

    {% if errors is defined and errors is not empty %}
        <div class="errors" role="alert">
            <ul>
                {% for error in errors %}
                    <li>{{ error }}</li>
                {% endfor %}
            </ul>
        </div>
    {% endif %}

    <form
        action="{{ base }}/login"
        method="post"
    >
        <label for="Username">
            Nom d’utilisateur
        </label>

        <input
            id="Username"
            name="Username"
            type="text"
            maxlength="50"
            value="{{ username|default('') }}"
            autocomplete="username"
            required
        >

        <label for="Password">
            Mot de passe
        </label>

        <input
            id="Password"
            name="Password"
            type="password"
            autocomplete="current-password"
            required
        >

        <div class="actions">
            <button
                class="button"
                type="submit"
            >
                Se connecter
            </button>

            <a href="{{ base }}/inscription">
                Pas encore de compte ? Inscrivez-vous
            </a>
        </div>
    </form>
</section>

{% endblock %}
