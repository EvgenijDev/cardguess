<?php

namespace Core;

class CountryAPI
{
   private string $jsonFile;

   public function __construct()
   {
      $this->jsonFile = __DIR__ . '/../cache/countries.json';
   }

   /**
    * Получаем карточки для игры
    * @param int $pairs Количество пар
    * @return array
    */
   public function getCards(int $pairs = 20): array
   {
      if (!file_exists($this->jsonFile)) {
         throw new \Exception("JSON файл стран не найден: {$this->jsonFile}");
      }

      $data = json_decode(file_get_contents($this->jsonFile), true);

      if (!$data) {
         throw new \Exception("Невалидный JSON");
      }

      // Берём только страны с флагом
      $countries = array_filter($data, fn($c) => !empty($c['flags']['png']));

      // Перемешиваем и выбираем нужное количество
      shuffle($countries);
      $selected = array_slice($countries, 0, $pairs);

      $cards = [];
      $id = 1;

      foreach ($selected as $country) {
         $name = $country['translations']['rus']['common'] ?? $country['name']['common'];
         $image = $country['flags']['png'];

         // Делаем пару карточек
         $cards[] = ['id' => $id++, 'name' => $name, 'image' => $image];
         $cards[] = ['id' => $id++, 'name' => $name, 'image' => $image];
      }

      // Перемешиваем все карточки
      shuffle($cards);

      return $cards;
   }
}
