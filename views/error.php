{% extends 'layout.php' %}

{% block content %}

<section class="form-shell">
    <h1>
        {{ pageTitle }}
    </h1>

    <p>
        {{ message }}
    </p>

    <div class="actions">
        <a href="{{ base }}/">
            Retour à l’accueil
        </a>
    </div>
</section>

{% endblock %}
