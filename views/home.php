{% extends 'layout.php' %}

{% block content %}

<div class="home-page">
    <section class="hero home-hero">
        <h1>
            Bienvenue dans le Blogue coloré
        </h1>

        <p>
            Un espace pour partager des découvertes, développer ses connaissances et nourrrir sa créativité.
        </p>

        <a
            class="button"
            href="{{ base }}/articles"
        >
            Découvrir les articles
        </a>
    </section>
</div>

{% endblock %}