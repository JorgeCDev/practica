import Vue from "vue";
import vuetify from "@/plugins/vuetify";
import Dialog from "./Dialog.vue";

const CDialog = class {
  constructor(props) {
    const Constructor = Vue.extend(Dialog);
    this.dialog = new Constructor({
      vuetify,
      propsData: props,
    });
    // this.dialog = new Vue({
    //   vuetify,
    //   ...Dialog,
    //   propsData: props || {}
    // })
  }

  get() {
    return this.dialog.$el;
  }

  open() {
    this.dialog.$mount();
  }

  append(element, get = true) {
    this.dialog.$refs.dialog_body.append(get ? element.get() : element);
  }

  appendPage(Element, props = {}) {
    const instance = new Element({
      vuetify,
      propsData: props,
    });
    instance.$mount(document.getElementById(this.dialog.id));
  }

  addAction(element) {
    this.dialog.$refs.actions.append(element);
  }

  close() {
    this.dialog.close();
  }

  clean() {
    this.dialog.clean();
  }
};

export default CDialog;
