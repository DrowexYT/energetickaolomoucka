<template>
  <header class="main-header">
    <nav class="navbar">
      <div class="logo">Energetická Olomoucká</div>
      <ul class="nav-links">
        <li><a href="#">Domů</a></li>
        <li><a href="#">Záznamy</a></li>
        <li><a href="#">Kontakt</a></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: "MainHeader"
};
</script>

<style scoped>
.main-header {
  background: linear-gradient(90deg, #f655ba, #09a112);
  color: #fff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
}
.logo {
  font-size: 1.5rem;
  font-weight: bold;
}
.nav-links {
  list-style: none;
  display: flex;
  gap: 2rem;
}
.nav-links a {
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s;
}
.nav-links a:hover {
  color: #f655ba;
}
</style>
