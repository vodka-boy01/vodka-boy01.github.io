<?php
  $conn = (new database())->connect();
  $userOperations = new user($conn);
  $operations = new operations($conn);

  if(!isset($_SESSION['username'])){
    header("Location: pages/login.php");

  }

  $userInfo = $userOperations->getUserInfo($_SESSION['username']);

?>
<section class="max-w-xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-lg">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Profilo Utente</h2>
  <div class="space-y-2">
    <p><span class="font-medium">Nome:</span> <?= htmlspecialchars($userInfo['name']) ?></p>
    <p><span class="font-medium">Cognome:</span> <?= htmlspecialchars($userInfo['surname']) ?></p>
    <p><span class="font-medium">Username:</span> <?= htmlspecialchars($userInfo['username']) ?></p>
    <p><span class="font-medium">Email:</span> <?= htmlspecialchars($userInfo['email']) ?></p>
    <p><span class="font-medium">Ultimo Login:</span> <?= htmlspecialchars($userInfo['latest_login']) ?></p>
    <p><span class="font-medium">Data Creazione account:</span> <?= htmlspecialchars($userInfo['data_creazione']) ?></p>
    <p><span class="font-medium">Livello autorizzazione account:</span> <?= htmlspecialchars($userOperations->getUserRole($userInfo['username'])) ?></p>
  </div>
</section>
