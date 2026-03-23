<template>
  <section class="records-list">
    <div id="items">
      <div class="item" v-for="item in items" :key="item.id">
        <span>{{ item.name }} {{ item.flavor }} - {{ item.sell_price }} Kč ({{ item.quantity }} k dispozici)</span>
        <div class="quantity-controls">
          <button class="minus" @click="$emit('update-quantity', { id: item.id, quantity: (quantities[item.id] || 0) - 1 })">-</button>
          <span class="quantity">{{ quantities[item.id] || 0 }}</span>
          <button class="plus" @click="$emit('update-quantity', { id: item.id, quantity: (quantities[item.id] || 0) + 1 })" :disabled="(quantities[item.id] || 0) >= item.quantity">+</button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'RecordsList',
  props: {
    items: Array,
    quantities: Object
  }
};
</script>

<style scoped>
.records-list {
  margin: 2rem auto;
  max-width: 700px;
  background: #2c3e50;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
  padding: 20px;
}
#items {
  margin-bottom: 20px;
}
.item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px;
  margin: 10px 0;
  border: 1px solid #4a6076;
  border-radius: 10px;
  background-color: #34495e;
  font-size: 15px;
  transition: transform 0.2s, box-shadow 0.2s, background-color 0.2s;
}
.item:hover {
  transform: scale(1.02);
  background-color: #3e5a74;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
}
.item span {
  flex: 1;
  margin-right: 10px;
  color: #f5f5f5;
}
.quantity-controls {
  display: flex;
  align-items: center;
  gap: 10px;
}
.quantity-controls button {
  background-color: #1abc9c;
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 17px;
  transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
}
.quantity-controls button:hover {
  background-color: #16a085;
  transform: scale(1.05);
  box-shadow: 0 0 8px rgba(26, 188, 156, 0.5);
}
.quantity-controls button:disabled {
  background-color: #7f8c8d;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}
.quantity-controls .quantity {
  width: 30px;
  text-align: center;
  font-size: 17px;
  color: #f5f5f5;
}
</style>
