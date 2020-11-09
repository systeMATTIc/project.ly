const { default: draggable } = require("vuedraggable");

require("./bootstrap");

window.Vue = require("vue");

Vue.component("incomplete-tasks", require("./components/Tasks.vue").default);

const app = new Vue({
    el: "#app"
});
