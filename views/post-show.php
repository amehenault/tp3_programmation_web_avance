{% extends 'layout.php' %}

{% block content %}

<article class="article-full">
    <div class="article-topline">
        <p class="tag">
            {{ post.Categories ?? 'Sans catégorie' }}
        </p>

        <p class="meta">
            {{ post.Create_at|date('d/m/Y') }}
        </p>
    </div>

    <h1>
        {{ post.Titre }}
    </h1>

    <p class="byline">
        Par {{ post.Auteur }}
    </p>

    {% if post.Image %}
        <img
            class="article-image"
            src="{{ base }}/images/{{ post.Image }}"
            alt="{{ post.Titre }}"
        >
    {% endif %}

    <div class="article-content">
        {{ post.Contenu|nl2br }}
    </div>

    <div class="actions">
        <a href="{{ base }}/articles">
            Retour aux articles
        </a>

        {% if isAdmin %}
            <a href="{{ base }}/article/edit?id={{ post.idPosts }}">
                Modifier
            </a>
        {% endif %}
    </div>
</article>

{% endblock %}