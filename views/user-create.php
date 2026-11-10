{% extends 'layout.php' %}

{% block content %}

<section class="form-shell">
    <h1>
        {% if isAdmin %}
            Ajouter un utilisateur
        {% else %}
            Créer un compte
        {% endif %}
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
        action="{{ base }}/inscription"
        method="post"
    >
        <label for="Nom">
            Nom
        </label>

        <input
            id="Nom"
            name="Nom"
            type="text"
            maxlength="100"
            value="{{ nom|default('') }}"
            required
        >

        <label for="Email">
            Courriel
        </label>

        <input
            id="Email"
            name="Email"
            type="email"
            maxlength="100"
            value="{{ email|default('') }}"
            required
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
            Mot de passe (8 caractères minimum)
        </label>

        <input
            id="Password"
            name="Password"
            type="password"
            minlength="8"
            autocomplete="new-password"
            required
        >

        <label for="Confirmation">
            Confirmer le mot de passe
        </label>

        <input
            id="Confirmation"
            name="Confirmation"
            type="password"
            minlength="8"
            autocomplete="new-password"
            required
        >

        {# Seul l'administrateur peut choisir le rôle #}
        {% if isAdmin %}
            <label for="Role">
                Rôle
            </label>

            <select
                id="Role"
                name="Role"
            >
                <option value="client">
                    Client
                </option>

                <option
                    value="admin"
                    {% if role|default('') == 'admin' %}selected{% endif %}
                >
                    Administrateur
                </option>
            </select>
        {% endif %}

        <div class="actions">
            <button
                class="button"
                type="submit"
            >
                {% if isAdmin %}
                    Ajouter l’utilisateur
                {% else %}
                    Créer mon compte
                {% endif %}
            </button>

            {% if isAdmin %}
                <a href="{{ base }}/admin/users">
                    Annuler
                </a>
            {% else %}
                <a href="{{ base }}/login">
                    J’ai déjà un compte
                </a>
            {% endif %}
        </div>
    </form>
</section>

{% endblock %}
