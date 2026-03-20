<template>
  <div class="container">
    <MainHeader />
    <h2>Energetická Olomoucká</h2>
    <h3>Vyber, zkopíruj a pošli na IG</h3>
    <div class="filter-container">
      <button class="filter-btn" :class="{ active: selectedBrand === 'all' }" @click="filterBrand('all')">Vše</button>
      <button v-for="brand in brands" :key="brand" class="filter-btn" :class="{ active: selectedBrand === brand }" @click="filterBrand(brand)">{{ brand }}</button>
    </div>
    <RecordsList :items="filteredItems" :quantities="quantities.value" @update-quantity="handleUpdateQuantity" />
    <h3>Tvoje objednávka</h3>
    <div id="order-message">{{ orderMessage }}</div>
    <div class="copy-container">
      <button id="copy-message" class="copy-message" @click="copyOrder"><i class="fas fa-copy"></i> Kopírovat objednávku</button>
    </div>
    <div v-if="isAdmin" class="record-sale-link" id="record-sale-link">
      <a href="#" id="record-sale-anchor">Zaznamenat prodej</a>
    </div>
    <div class="instagram-links">
      <p>Objednávku zašlete na Instagram:</p>
      <a href="https://www.instagram.com/energetickaolomoucka/" target="_blank">@energetickaolomoucka</a>
    </div>
    <div v-if="isAdmin">
      <a href="#" class="logout-btn">Odhlásit se</a>
    </div>
    <div v-else>
      <a href="#" class="auth-btn">Přihlásit se (Admin)</a>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import MainHeader from './components/MainHeader.vue';
import RecordsList from './components/RecordsList.vue';
import itemsData from './lib/records.json';

const items = ref(itemsData);
const quantities = ref({});
const selectedBrand = ref('all');
const isAdmin = ref(false);

const brands = computed(() => {
  const allBrands = items.value.map(item => item.brand);
  return [...new Set(allBrands)];
});

const filteredItems = computed(() => {
  if (selectedBrand.value === 'all') {
    return items.value;
  }
  return items.value.filter(item => item.brand === selectedBrand.value);
});

const orderMessage = computed(() => {
  let message = 'Čau, chci si objednat:\n';
  let hasItems = false;
  for (const id in quantities.value) {
    if (quantities.value[id] > 0) {
      const item = items.value.find(item => item.id === parseInt(id));
      if (item) {
        message += `${item.name} ${item.flavor}: ${quantities.value[id]}x\n`;
        hasItems = true;
      }
    }
  }
  return hasItems ? message : 'Nejdřív si něco vyber :)';
});

function filterBrand(brand) {
  selectedBrand.value = brand;
}

function handleUpdateQuantity({ id, quantity }) {
  if (!quantities.value[id]) {
    quantities.value[id] = 0;
  }
  quantities.value[id] = quantity;
}

function copyOrder() {
  navigator.clipboard.writeText(orderMessage.value).then(() => {
    alert('Objednávka zkopírována!');
  });
}

onMounted(() => {
  items.value.forEach(item => {
    quantities.value[item.id] = 0;
  });
});
</script>

<style scoped>
.container {
  max-width: 60%;
  margin: 0 auto;
  background: #2c3e50;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
}
@media (max-width: 768px) {
  .container {
    max-width: 100%;
    padding: 15px;
  }
  body {
    padding: 10px;
  }
}
h2, h3 {
  text-align: center;
  color: #f5f5f5;
  margin: 15px 0;
  font-weight: 600;
}
h2 {
  font-size: 1.8em;
}
h3 {
  font-size: 1.4em;
}
.filter-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 10px;
  margin-bottom: 15px;
}
.filter-btn {
  background-color: #34495e;
  color: #f5f5f5;
  padding: 10px 15px;
  border: 1px solid #4a6076;
  border-radius: 10px;
  font-size: 15px;
  cursor: pointer;
  transition: background-color 0.2s, box-shadow 0.2s, transform 0.1s;
}
.filter-btn:hover {
  background-color: #3e5a74;
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.4);
  transform: scale(1.02);
}
.filter-btn.active {
  background-color: #1abc9c;
  border-color: #16a085;
}
.filter-btn.active:hover {
  background-color: #16a085;
  box-shadow: 0 0 8px rgba(26, 188, 156, 0.5);
}
#order-message {
  margin-top: 20px;
  padding: 15px;
  border: 1px solid #4a6076;
  border-radius: 10px;
  background-color: #34495e;
  white-space: pre-wrap;
  font-size: 15px;
  color: #f5f5f5;
  user-select: text;
}
.copy-container {
  margin-top: 15px;
}
.copy-message {
  background-color: #27ae60;
  color: white;
  padding: 12px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  width: 100%;
  font-size: 17px;
  transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
}
.copy-message:hover {
  background-color: #219653;
  transform: scale(1.02);
  box-shadow: 0 0 8px rgba(39, 174, 96, 0.5);
}
.record-sale-link {
  margin-top: 15px;
  text-align: center;
}
.record-sale-link a {
  display: inline-block;
  padding: 12px 20px;
  background-color: #e67e22;
  color: white;
  text-decoration: none;
  border-radius: 10px;
  font-size: 17px;
  transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
}
.record-sale-link a:hover {
  background-color: #d35400;
  transform: scale(1.02);
  box-shadow: 0 0 8px rgba(230, 126, 34, 0.5);
}
.instagram-links {
  margin-top: 20px;
  text-align: center;
}
.instagram-links p {
  color: #f5f5f5;
  margin-bottom: 10px;
}
.instagram-links a {
  display: inline-block;
  padding: 12px 20px;
  background-color: #C13584;
  color: white;
  text-decoration: none;
  border-radius: 10px;
  font-size: 17px;
  transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
}
.instagram-links a:hover {
  background-color: #9b2c6b;
  transform: scale(1.02);
  box-shadow: 0 0 8px rgba(193, 53, 132, 0.5);
}
.auth-btn {
  background-color: #1abc9c;
  color: white;
  padding: 12px;
  border: none;
  border-radius: 10px;
  width: 100%;
  text-align: center;
  text-decoration: none;
  display: block;
  margin-top: 15px;
  font-size: 17px;
  transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
}
.auth-btn:hover {
  background-color: #16a085;
  transform: scale(1.02);
  box-shadow: 0 0 8px rgba(26, 188, 156, 0.5);
}
.logout-btn {
  background-color: #c0392b;
  color: white;
  padding: 12px;
  border: none;
  border-radius: 10px;
  width: 100%;
  text-align: center;
  text-decoration: none;
  display: block;
  margin-top: 15px;
  font-size: 17px;
  transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
}
.logout-btn:hover {
  background-color: #992d22;
  transform: scale(1.02);
  box-shadow: 0 0 8px rgba(192, 57, 43, 0.5);
}
</style>
