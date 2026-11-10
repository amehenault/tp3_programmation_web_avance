{% extends 'layout.php' %}

{% block content %}

<section class="section-heading">
    <div>
        <h1>
            Utilisateurs
        </h1>
    </div>

    <a
        class="button"
        href="{{ base }}/inscription"
    >
        Ajouter un utilisateur
    </a>
</section>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Nom d’utilisateur</th>
                <th>Courriel</th>
                <th>Rôle</th>
            </tr>
        </thead>

        <tbody>
            {% for user in users %}
                <tr>
                    <td>{{ user.Nom }}</td>
                    <td>{{ user.Username }}</td>
                    <td>{{ user.Email }}</td>
                    <td>
                        {% if user.Role == 'admin' %}
                            Administrateur
                        {% else %}
                            Client
                        {% endif %}
                    </td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{% endblock %}
