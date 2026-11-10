<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ pageTitle|default('Blogue coloré') }}</title>

    <link rel="stylesheet" href="{{ base }}/css/style.css">
</head>
<body>

<header class="site-header">
    <a
        class="logo"
        href="{{ base }}/"
    >
        Blogue coloré
    </a>

    <nav aria-label="Navigation principale">
        <a href="{{ base }}/">
            Accueil
        </a>

        <a href="{{ base }}/articles">
            Articles
        </a>

        {# Liens réservés à l'administrateur #}
        {% if isAdmin %}
            <a href="{{ base }}/admin">
                Administration
            </a>

            <a href="{{ base }}/journal">
                Journal de bord
            </a>
        {% endif %}

        {% if isLogged %}
            <a href="{{ base }}/profil">
                Mon profil ({{ userName }})
            </a>

            <a
                class="button small"
                href="{{ base }}/logout"
            >
                Déconnexion
            </a>
        {% else %}
            <a href="{{ base }}/inscription">
                Inscription
            </a>

            <a
                class="button small"
                href="{{ base }}/login"
            >
                Connexion
            </a>
        {% endif %}
    </nav>
</header>

<main class="container">
    {% if notice %}
        <div class="notice" role="status">
            {{ notice }}
        </div>
    {% endif %}

    {% block content %}{% endblock %}
</main>

<footer class="site-footer">
    <p>
        Projet TP3 de Programmation Web avancée — Créé par Amélie Hénault
    </p>
</footer>

</body>
</html>
