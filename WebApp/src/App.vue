<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
export default {
}
</script>

<style>
  :root {
    font-size: 62.5%;

	--color-primary: #3B82F6;
	--color-secondary: #0F172A;
	--color-tertiary: #CBD5E1;
	--color-quaternary: #F8FAFC;
	--color-delete-done: #E4295D;

	--font-family-primary: 'Roboto Slab', serif;
	--font-family-secondary: 'Roboto', sans-serif;

	--font-color-dark: #111;
	--font-color-mid: #353935;
	--font-color-light: #C0C0C0;
	--font-color-lighter: #F8FAFC;
}

* {
    box-sizing: border-box;
    margin: 0;
    border: 0;

	font-family: var(--font-family-secondary);
}

body {
    background-color: var(--color-tertiary);
}
</style>
