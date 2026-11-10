{% extends 'layout.php' %}

{% block content %}

<section class="form-shell">
    <h1>
        Ajouter un article
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
        action="{{ base }}/article/store"
        method="post"
        enctype="multipart/form-data"
    >
        <label for="Titre">
            Titre
        </label>

        <input
            id="Titre"
            name="Titre"
            type="text"
            maxlength="255"
            value="{{ titre|default('') }}"
            required
        >

        <label for="Contenu">
            Contenu
        </label>

        <textarea
            id="Contenu"
            name="Contenu"
            rows="10"
            required
        >{{ contenu|default('') }}</textarea>

        <label for="Image">
            Image (facultative — JPG, PNG, WEBP ou GIF, 2 Mo maximum)
        </label>

        <input
            id="Image"
            name="Image"
            type="file"
            accept="image/jpeg, image/png, image/webp, image/gif"
        >

        <label for="Users_idUsers">
            Auteur
        </label>

        <select
            id="Users_idUsers"
            name="Users_idUsers"
            required
        >
            <option value="">
                Choisir un auteur
            </option>

            {% for user in users %}
                <option
                    value="{{ user.idUsers }}"
                    {% if user.idUsers == (idUser|default(0)) %}selected{% endif %}
                >
                    {{ user.Nom }}
                </option>
            {% endfor %}
        </select>

        <fieldset>
            <legend>
                Catégories
            </legend>

            <div class="checkboxes">
                {% for categorie in categories %}
                    <label class="checkbox">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ categorie.idCategories }}"
                            {% if categorie.idCategories in (categoryIds|default([])) %}checked{% endif %}
                        >

                        {{ categorie.Nom }}
                    </label>
                {% endfor %}
            </div>
        </fieldset>

        <button
            class="button"
            type="submit"
        >
            Publier l’article
        </button>

        <a href="{{ base }}/admin">
            Annuler et revenir à l’administration
        </a>
    </form>
</section>

{% endblock %}