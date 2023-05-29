/* eslint-disable no-undef */
import Vue from "vue";
import Vuex from "vuex";
import ApiService from "../util/ApiService";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    products: [],
    product: {},
    categories: [],
    features: [],
  },
  getters: {},
  mutations: {
    SET_FEATURES(state, features) {
      state.features = features;
    },
    SET_CATEGORIES(state, categories) {
      state.categories = categories;
    },
  },
  actions: {
    fetchCategories({ commit }) {
      ApiService({
        url: "/product/category",
        method: "get",
      })
        .then((resp) => {
          if (resp) {
            const values = resp.data.data.map((item) => {
              return item.category;
            });
            commit("SET_CATEGORIES", values);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    fetchFeatures({ commit }, product) {
      ApiService({
        url: `/feature?pid =${product}`,
        method: "get",
      })
        .then((resp) => {
          if (resp) {
            commit("SET_FEATURES", resp.data.data);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  modules: {},
});
