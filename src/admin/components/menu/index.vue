<template>
  <header>
    <nav>
      <div class="container">
        <ul>
          <li>
              <router-link :to="{name: 'documentos'}" >Documentos</router-link>
          </li>
          <li class="green" style="" >
              <router-link :to="{name: 'categorias'}" >Categorias</router-link>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
export default {};
</script>

<style scoped>
* {
  box-sizing: border-box;
}

header {
  background: #3d4144;

  border: none;

  border-bottom: 5px solid #2e3131;

  position: sticky;

  padding-top: 20px;

  top: 32px;

  z-index: 1000;

}

nav {
  height: 36px;

  background: #464b4c;

  border-top: 1px solid #353939;

  border-bottom: 1px solid #2e3131;

  background-image: -webkit-linear-gradient(top, #464b4c, #3f4344);

  background-image: -moz-linear-gradient(top, #464b4c, #3f4344);

  background-image: -o-linear-gradient(top, #464b4c, #3f4344);

  background-image: linear-gradient(to bottom, #464b4c, #3f4344);

  -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.06);

  box-shadow: inset 0 1px rgba(255, 255, 255, 0.06);
}

nav a {
  -webkit-transition: 0.1s ease-out;

  -moz-transition: 0.1s ease-out;

  -o-transition: 0.1s ease-out;

  transition: 0.1s ease-out;

  -webkit-transition-property: background-color, line-height;

  -moz-transition-property: background-color, line-height;

  -o-transition-property: background-color, line-height;

  transition-property: background-color, line-height;
}

nav ul {
  display: flex;

  padding: 0;

  margin: 0;

  border-left: 1px solid #353939;

  border-left: 1px solid rgba(0, 0, 0, 0.2);

  border-right: 1px solid #4d5354;

  border-right: 1px solid rgba(255, 255, 255, 0.06);
}

nav li {
    margin: 0;
}

nav a {
  display: block;

  padding: 0 20px;

  line-height: 36px;

  color: #ddd;

  text-decoration: none;

  text-shadow: 0 -1px #2e3131;

  border-left: 1px solid #4d5354;

  border-left: 1px solid rgba(255, 255, 255, 0.06);

  border-right: 1px solid #353939;

  border-right: 1px solid rgba(0, 0, 0, 0.2);

  cursor: pointer;
}

nav a:hover {
  background: #4d5354;

  background: rgba(255, 255, 255, 0.05);
}

nav li a.active,
nav li a.active:hover,
nav a:active {
  padding: 0 21px;

  line-height: 33px;

  color: #eee;

  background: #323637;

  border-left: 0;

  border-right: 0;

  /* border-bottom: 3px solid #48a9c0; */
  border-bottom: 3px solid #0073aa;

  background-image: -webkit-linear-gradient(top, #484e4f, #323637);

  background-image: -moz-linear-gradient(top, #484e4f, #323637);

  background-image: -o-linear-gradient(top, #484e4f, #323637);

  background-image: linear-gradient(to bottom, #484e4f, #323637);

  -webkit-box-shadow: inset 0 -1px #151717, inset 0 -1px 8px rgba(0, 0, 0, 0.2);

  box-shadow: inset 0 -1px #151717, inset 0 -1px 8px rgba(0, 0, 0, 0.2);
}

.dashicons {
  vertical-align: middle;
}

.dashicons:first-child {
  margin-right: 10px;
}

#config {
  margin-left: auto;
}

nav li.green a,
nav li.green a:active {
  border-bottom-color: #56c93d;
}

nav li.red a,
nav li.red a:active {
  border-bottom-color: #a54e49;
}

nav li.purple a,
nav li.purple a:active {
  border-bottom-color: #c052b9;
}

nav li.yellow a,
nav li.yellow a:active {
  border-bottom-color: #c0bb30;
}

nav li.green a,
nav li.green a:active {
  border-bottom-color: #56c93d;
}
</style>