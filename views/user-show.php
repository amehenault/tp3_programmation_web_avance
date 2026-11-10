{% extends 'layout.php' %}

{% block content %}

<section class="form-shell">
    <h1>
        Mon profil
    </h1>

    <dl class="profile">
        <dt>Nom</dt>
        <dd>{{ user.Nom }}</dd>

        <dt>Courriel</dt>
        <dd>{{ user.Email }}</dd>

        <dt>Nom d’utilisateur</dt>
        <dd>{{ user.Username }}</dd>

        <dt>Rôle</dt>
        <dd>
            {% if user.Role == 'admin' %}
                Administrateur
            {% else %}
                Client
            {% endif %}
        </dd>
    </dl>

    <div class="actions">
        <a
            class="button"
            href="{{ base }}/articles"
        >
            Lire les articles
        </a>

        {% if isAdmin %}
            <a href="{{ base }}/admin">
                Aller à l’administration
            </a>
        {% endif %}
    </div>
</section>

{% endblock %}
