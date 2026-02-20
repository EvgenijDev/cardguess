<template>
   <div class="board">
     <Card
       v-for="card in cards"
       :key="card.id"
       :card="card"
       :flipped="flippedCards.includes(card.id)"
       :matched="matchedCards.includes(card.id)"
       @flip="onFlip"
     />
   </div>
 </template>
 
 <script>
 import { ref, onMounted } from 'vue'
 import Card from './Card.vue'
 
 export default {
   components: { Card },
   setup() {
     const cards = ref([])            // все карточки
     const flippedCards = ref([])     // открытые карты
     const matchedCards = ref([])     // совпавшие пары
 
     // загрузка карточек с API
     const loadCards = async () => {
       try {
         const res = await fetch('/api/cards.php')
         cards.value = await res.json()
         console.log('loadCards');
       } catch (e) {
         console.error('Ошибка загрузки карточек', e)
       }
     }
 
     const onFlip = (card) => {
       if (flippedCards.value.includes(card.id) || matchedCards.value.includes(card.id)) return
 
       flippedCards.value.push(card.id)
 
       if (flippedCards.value.length === 2) {
         const [firstId, secondId] = flippedCards.value
         const firstCard = cards.value.find(c => c.id === firstId)
         const secondCard = cards.value.find(c => c.id === secondId)
 
         if (firstCard.name === secondCard.name) {
           matchedCards.value.push(firstId, secondId)
         }
 
         // сброс открытых карт через 1 секунду
         setTimeout(() => flippedCards.value = [], 1000)
       }
     }
 
     onMounted(loadCards)
 
     return { cards, flippedCards, matchedCards, onFlip }
   }
 }
 </script>
 
 <style scoped>
.board {
  display: grid;
  grid-template-columns: repeat(auto-fill, 130px);
  grid-gap: 10px;
  justify-content: center;
  margin-top: 20px;
}

 </style>
 