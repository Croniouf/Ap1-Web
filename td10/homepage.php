<?php 
$title = "Le blog de l'AVBN";
ob_start(); 
?>
     
<h1>Le super blog de l'AVBN !</h1>
<p>Derniers billets du blog :</p>

<?php if (empty($posts)): ?>
    <p>Aucun billet pour le moment.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
    <div class="news">
        <h3>
            <?= htmlspecialchars($post['title']) ?>
            <em>le <?= htmlspecialchars($post['french_creation_date']) ?></em>
        </h3>
        <p>
            <?= nl2br(htmlspecialchars($post['content'])) ?>
            <br />
            <em><a href="index.php?action=post&id=<?= $post['id'] ?>">Commentaires</a></em>
        </p>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php 
$content = ob_get_clean();
require('layout.php');
?>