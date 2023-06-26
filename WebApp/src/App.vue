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
}

* {
    box-sizing: border-box;
    margin: 0;
    border: 0;
}

body {
    background-color: var(--color-tertiary);
}
</style>
