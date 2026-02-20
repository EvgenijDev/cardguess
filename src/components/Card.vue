<template>
   <div class="card" @click="flip" :class="{ flipped: flipped || matched }">
     <div class="front">
       <img :src="card.image" alt="" />
       <h5><span>{{card.name}}</span></h5>
     </div>
     <div class="back">?</div>
   </div>
 </template>
 
 <script>
 export default {
   props: ['card', 'flipped', 'matched'],
   emits: ['flip'],
   methods: {
     flip() {
       if (!this.flipped && !this.matched) this.$emit('flip', this.card)
     }
   }
 }
 </script>
 
 <style scoped>
 .card {
   width: 130px;
   height: 160px;
   perspective: 600px;
   cursor: pointer;
   position: relative;
 }
 .card > div {
   width: 100%;
   height: 100%;
   position: absolute;
   border-radius: 10px;
   backface-visibility: hidden;
   display: flex;
   justify-content: center;
   align-items: center;
   transition: transform 0.5s;
 }
 .card .front {
   transform: rotateY(180deg);
   background: rgb(126, 150, 211);
   display: flex;
   flex-direction: column;
 }
 .card .front img {
   width: 130px;
   height: 80px;
 }
 .card .front span {
   color: white;
   height: 80px;
 }
 .card .back {
   background: #2196f3;
   color: white;
   font-size: 2rem;
 }
 .card.flipped .front,
 .card.matched .front {
   transform: rotateY(0deg);
 }
 .card.flipped .back,
 .card.matched .back {
   transform: rotateY(180deg);
 }
 </style>
 