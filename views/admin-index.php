{% extends 'layout.php' %}

{% block content %}

<section class="section-heading">
    <div>
        <h1>
            Administration
        </h1>
    </div>

    <div class="actions">
        <a
            class="button secondary"
            href="{{ base }}/admin/users"
        >
            Utilisateurs
        </a>

        <a
            class="button"
            href="{{ base }}/article/create"
        >
            Ajouter un article
        </a>
    </div>
</section>

<div class="stats">
    <div class="stat">
        <strong>{{ nbPosts }}</strong>
        Articles
    </div>

    <div class="stat">
        <strong>{{ nbUsers }}</strong>
        Utilisateurs
    </div>

    <div class="stat">
        <strong>{{ nbVisites }}</strong>
        Visites enregistrées
    </div>
</div>

<h2>
    Gérer les articles
</h2>

{% if posts is empty %}

    <div class="empty">
        Aucun article.
    </div>

{% else %}

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Catégories</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                {% for post in posts %}
                    <tr>
                        <td>{{ post.Titre }}</td>
                        <td>{{ post.Auteur }}</td>
                        <td>{{ post.Categories ?? 'Sans catégorie' }}</td>
                        <td>{{ post.Create_at|date('d/m/Y') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ base }}/article?id={{ post.idPosts }}">
                                    Voir
                                </a>

                                <a href="{{ base }}/article/edit?id={{ post.idPosts }}">
                                    Modifier
                                </a>

                                <form
                                    action="{{ base }}/article/delete"
                                    method="post"
                                    onsubmit="return confirm('Supprimer cet article ?');"
                                >
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="{{ post.idPosts }}"
                                    >

                                    <button
                                        class="link danger"
                                        type="submit"
                                    >
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>

{% endif %}

{% endblock %}
