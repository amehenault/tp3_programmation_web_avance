{% extends 'layout.php' %}

{% block content %}

<section class="section-heading">
    <div>
        <h1>
            Journal de bord
        </h1>
    </div>
</section>

{% if journal is empty %}

    <div class="empty">
        Aucune visite enregistrée.
    </div>

{% else %}

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Date et heure</th>
                    <th>Adresse IP</th>
                    <th>Utilisateur</th>
                    <th>Page visitée</th>
                </tr>
            </thead>

            <tbody>
                {% for visite in journal %}
                    <tr>
                        <td>{{ visite.Date_visite|date('d/m/Y H:i:s') }}</td>
                        <td>{{ visite.Ip }}</td>
                        <td>{{ visite.Username }}</td>
                        <td>{{ visite.Page }}</td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>

{% endif %}

{% endblock %}
