<?php
header('Content-Type: application/json');

require_once __DIR__ . '/core/CountryAPI.php';

use Core\CountryAPI;

try {
   $api = new CountryAPI();

   // Получаем карточки для игры
   $cards = $api->getCards(20); // 20 пар → 40 карточек

   echo json_encode($cards);
} catch (Exception $e) {
   http_response_code(500);
   echo json_encode([
      'error' => $e->getMessage()
   ]);
}
