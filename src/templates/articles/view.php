<?php include __DIR__.'/../header.php' ?>
    <td>
        <h1><?=$article->getName()?></h1>
        <p><?=$article->getText()?></p>
        <p><?=$article->getAuthor()->getNickname()?></p>
    </td>
<?php include __DIR__.'/../footer.php' ?>