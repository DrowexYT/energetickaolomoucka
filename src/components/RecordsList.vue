<template>
  <section class="records-list">
    <h2>Zákazníci</h2>
    <table>
      <thead>
        <tr>
          <th>Jméno</th>
          <th>Celkem zaplaceno</th>
          <th>Poznámky</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="record in records" :key="record.id">
          <td>{{ record.name }}</td>
          <td>{{ record.total_paid }} Kč</td>
          <td>{{ record.notes }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script>
import records from '../lib/records.json';
export default {
  name: 'RecordsList',
  data() {
    return {
      records
    };
  }
};
</script>

<style scoped>
.records-list {
  margin: 2rem auto;
  max-width: 900px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  padding: 2rem;
}
h2 {
  margin-bottom: 1rem;
  color: #f655ba;
}
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid #eee;
}
th {
  background: #f655ba;
  color: #fff;
}
tr:last-child td {
  border-bottom: none;
}
</style>
