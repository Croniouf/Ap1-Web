<?php $title = htmlspecialchars($post['title']) . " - Le blog de l'AVBN" ?>

<?php ob_start(); ?>
        <h1>Le super blog de l'AVBN !</h1>
        <p><a href="index.php">Retour à la liste des billets</a></p>

        <div class="news">
            <h3>
                <?= htmlspecialchars($post['title']) ?>
                <em>le <?= htmlspecialchars($post['french_creation_date']) ?></em>      
            </h3>
 
            <p>
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </p>
        </div>
 
        <h2>Commentaires</h2>

        <?php if (empty($comments)): ?>
            <p>Aucun commentaire pour le moment.</p>
        <?php endif; ?>

        <?php foreach ($comments as $comment): ?>
        <div class="news">
            <h3>
                <?= htmlspecialchars($comment['author_email']) ?>
                <em>le <?= htmlspecialchars($comment['french_creation_date']) ?></em>
            </h3>
            <p>
                <?= nl2br(htmlspecialchars($comment['comment'])) ?>
            </p>
        </div>
        <?php endforeach; ?>

        <h3>Ajouter un commentaire</h3>
        <form action="index.php?action=addComment&id=<?= htmlspecialchars($post['identifier']) ?>" method="post">
            <div>
                <label for="author">Auteur</label><br />
                <input type="text" id="author" name="author" required />
            </div>
            <div>
                <label for="comment">Commentaire</label><br />
                <textarea id="comment" name="comment" required></textarea>
            </div>
            <div>
                <input type="submit" value="Poster le commentaire" />
            </div>
        </form>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>