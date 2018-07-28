<?php
$lang['created'] = 'Créé';
$lang['errors'] = 'Erreurs';
$lang['evtdesc_CmsJobManager::OnJobFailed'] = 'Envoyé après qu\'une tâche a été supprimée de la file d\'attente après avoir échouée trop souvent';
$lang['evthelp_CmsJobManager::OnJobFailed'] = '<h4>Paramètres :</h4>
<ul>
  <li>"job" - une référence à la tâche qui a échouée \\CMSMS\\Async\\Job</li>
</ul>\';';
$lang['frequency'] = 'Fréquence';
$lang['friendlyname'] = 'Gestionnaire des tâches';
$lang['info_background_jobs'] = 'Ce panneau contient des informations sur toutes les tâches de fond actuellement connues. Il est normal que les tâches apparaissent et disparaissent de cette liste fréquemment. Si une tâche a un nombre élevé d\'erreurs ou ne commence jamais, cela peut signifier que vous avez besoin d\'enquêter sur les raisons de cette erreur.';
$lang['info_no_jobs'] = 'Il n\'y a pas de tâche(s) dans la file d\'attente';
$lang['jobs'] = 'tâche';
$lang['moddescription'] = 'Un module de gestion et de traitement des tâches de fond asynchrones.';
$lang['module'] = 'Module &nbsp;';
$lang['name'] = 'Nom';
$lang['processing_freq'] = 'Fréquence maximale de traitement (secondes)';
$lang['recur_120m'] = 'Toutes les 2 heures';
$lang['recur_15m'] = 'Toutes les 15 minutes';
$lang['recur_180m'] = 'Toutes les 3 heures';
$lang['recur_30m'] = 'Toutes les 30 minutes';
$lang['recur_daily'] = 'Tous les jours';
$lang['recur_hourly'] = 'Toutes les heures';
$lang['recur_monthly'] = 'Tous les mois';
$lang['recur_weekly'] = 'Toutes les semaines';
$lang['settings'] = 'Paramètres';
$lang['start'] = 'Début';
$lang['until'] = 'Jusqu\'à';
$lang['help'] = '<h3>Que fait ce module ?</h3>
<p>Le Gestionnaire des tâches (CmsJobManager) est un module de base de CMSMS qui fournit des fonctionnalités pour le traitement des tâches de manière asynchrone (en arrière-plan/tâche de fond) pour des commandes routinières du site.</p>
<p>CMSMS et les modules tiers peuvent créer des tâches pour effectuer des traitements qui ne nécessitent pas l\'intervention directe de l\'utilisateur ou qui peuvent prendre un certain temps de réalisation. Ce module fournit les possibilités de traitement de ces tâches.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Ce module n\'a aucune interaction propre. Il fournit une liste de tâches simple qui énumère les traitements que le gestionnaire réalise actuellement dans sa file d\'attente. Des tâches peuvent apparaître régulièrement sur, et hors de cette file d\'attente et rafraîchir la page de temps en temps peut donner une indication sur ce qui se passe en arrière-plan de votre site.</p>
<p>Ce module traitera uniquement des tâches chaque minute, et au moins toutes les dix minutes. La valeur par défaut est de 3 minutes. Ce traitement est peu fréquent afin d\'assurer une performance raisonnable sur la plupart des sites Web.</p>
<p>Vous pouvez ajuster la fréquence en ajoutant une variable <strong>cmsjobmgr_asyncfreq</strong> dans le fichier config.php de votre site contenant une valeur entière entre 0 et 10 (en minutes).</p>
<pre>Exemple : <code>$config["cmsjobmgr_asyncfreq"] = 5;</code>.</pre>
<p><strong>Note :</strong> Il est impossible de désactiver complètement le traitement asynchrone. En effet, certaines fonctions du noyau CMSMS utilisent cette fonctionnalité.</p>
<h3>Assurer le traitement en arrière-plan.</h3>
<p>Sur certains sites à faible demande où les requêtes peuvent ne pas se produire fréquemment, mais où vous voulez vous assurer que le traitement en arrière-plan se produit, nous vous recommandons de configurer une tâche cron régulière (tous les 3 à 5 minutes) pour demander une URL sur le site. Il peut s\'agir d\'une simple page de contenu sans contenu propre qui n\'est pas affiché dans le menu.Exemple : </p>
<pre>*/3 * * * * wget -O /dev/null https://www.mysite.com/</pre>
<h3>Des problèmes sur les tâches ?</h3>
<p>De temps en temps certaines applications peuvent créer des tâches qui ne fonctionnent pas, en affichant une erreur. Le Gestionnaire des tâches (CmsJobManager) va supprimer la tâche après que la commande ait échouée un certain nombre de fois. Si vous rencontrez une tâche problématique qui continue à échouer, c\'est un bogue qui doit être diagnostiqué et rapporté en détail aux développeurs concernés.</p>';
?>