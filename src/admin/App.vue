<template>
  <div id="certificado">
    <main-menu></main-menu>
    <div class="container">      
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import mainMenu from "./components/menu";

export default {
  name: 'app',
  components: {
    mainMenu
  },
}
</script>

<style>

  #certificado {    
    min-height: calc(100vh - 32px);
    margin-left: -20px;
  }

  #certificado .container {
    padding: 0 15px;
  }

  #certificado .align-center {
    text-align: center;
  }

  #certificado .align-right {
    text-align: right;
  }

  #certificado .align-left {
    text-align: left;
  }

  #certificado .notice {
    margin: 15px 0 0;
    font-size: 20px;
    padding: 10px;
  }

  #certificado .tablenav-pages-navspan.button > * {
    color: inherit;
    background: none;
    text-decoration: inherit;
    font-size: inherit;
    font-size: 13px; 
    display: inline-block;
    min-width: inherit;
    min-height: inherit;
    border: none;
    vertical-align: middle;
    line-height: 30px;
    padding: 0 4px;
  }

  #certificado .tablenav-pages-navspan.button {    
    padding: 0 !important;
    overflow: hidden;
    user-select: none;
  }

  #certificado .tablenav-pages-navspan.button {
    margin: 0 1px;
  }

  .cols {
    display: grid;
    width: 100%;
    /* align-items: center;   */
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));  
  }

  .flex-align-top {
    align-items: stretch;
  }

  .cols-100 {
    grid-template-columns: 100%;
  }

  .cols-25-50-25 {
    grid-template-columns: 25% 50% 25%;
  }

  .cols-25-75 {
    grid-template-columns: 25% 75%;
  }

  .cols-45-10-45 {
    grid-template-columns: 45% 10% 45%;
  }

  .cols-15-85 {
    grid-template-columns: 15% 85%;
  }

  .cols-33 {
    grid-template-columns: repeat(3, 1fr);
  }

  .cols-50 {
    grid-template-columns: repeat(2, 1fr);
  }

  .cols {
    width: 100%;
  }
  .cols input,
  .cols select,
  .cols textarea,
  .cols label {
    width: 100% !important;
  }
  .cols > div {
    padding: 5px;
  }

  .cols .mx-datepicker {
    width: 100%;
  }

  .list-docs {
    border: 1px solid #ccc;
    border-bottom: none;
  }
  
  .list-docs li {
    border-bottom: 1px solid #ccc;
  }

  #certificado .button .dashicons {
    vertical-align: middle;
    display: inline-table;
  }
  .border {
    border: 1px solid #ccc;
  }
  .border-right {
    border-right: 1px solid #ccc;
  }
  .border-left {
    border-left: 1px solid #ccc;
  }
  .border-top {
    border-top: 1px solid #ccc;
  }
  .border-bottom {
    border-bottom: 1px solid #ccc;
  }
  .background-white {
    background-color: white;
  }

  #certificado tbody tr td {
    background-color: rgba(0, 128, 0, .1);
  }

  #certificado tbody tr.draft td {
    background-color: rgba(255, 0, 0, .1);
  }

  #certificado .view .dashicons-hidden{
    color: #ff0000;
  }

  #certificado .view .dashicons-visibility{
    color: green;
  }

  #certificado .shortcode {
    background-color: #007cba;
    color: white;
  }

  .padding-bottom {
    padding-bottom: 15px;
  }

  .padding-top {
    padding-top: 15px;
  }

  .padding-left {
    padding-left: 15px;
  }

  .padding-right {
    padding-right: 15px;
  }

  .padding-0 {
    padding: 0 !important;
  }

  .is-active.save {
    float: none;
  }
</style>
