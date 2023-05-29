<!-- eslint-disable vue/valid-v-slot -->
<template>
  <v-data-table
    :headers="headers"
    :items="this.products"
    sort-by="code"
    class="elevation-1"
    @dblclick:row="($event, { item }) => selectFeature(item)"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Practica Coppel</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              Nuevo Producto
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    v-if="formTitle === 'Editar Producto'"
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      disabled
                      v-model="editedItem.id"
                      label="Codigo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.name"
                      label="Nombre"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.category"
                      label="Categoría"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <!-- details -->
        <v-dialog v-model="details" persistent max-width="600px">
          <v-card>
            <v-card-title>
              <span class="text-h5">Detalles</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      :value="pCode"
                      label="Codigo"
                      disabled
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :value="pName"
                      label="Nombre"
                      disabled
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :value="pCategory"
                      label="Categoria"
                      disabled
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-data-table
                      :headers="headerDetails"
                      :items="features"
                      sort-by="feature"
                      class="elevation-1"
                    >
                      <template v-slot:top>
                        <v-toolbar flat>
                          <v-toolbar-title>Caracteristicas</v-toolbar-title>
                          <v-divider class="mx-4" inset vertical></v-divider>
                          <v-spacer></v-spacer>
                          <v-dialog v-model="featDialog" max-width="500px">
                            <template v-slot:activator="{ on, attrs }">
                              <v-btn
                                color="primary"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                              >
                                Agregar
                              </v-btn>
                            </template>
                            <v-card>
                              <v-card-title>
                                <span class="text-h5">{{
                                  "Nueva Caracteristica"
                                }}</span>
                              </v-card-title>

                              <v-card-text>
                                <v-container>
                                  <v-row>
                                    <v-col cols="12" sm="6" md="4">
                                      <v-text-field
                                        v-model="editedFeature.feature"
                                        label="Caracteristica"
                                      ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                      <v-text-field
                                        v-model="editedFeature.value"
                                        label="Valor"
                                      ></v-text-field>
                                    </v-col>
                                  </v-row>
                                </v-container>
                              </v-card-text>
                              <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                  color="blue darken-1"
                                  text
                                  @click="featDialog = false"
                                >
                                  Cancel
                                </v-btn>
                                <v-btn
                                  color="blue darken-1"
                                  text
                                  @click="saveFeatDialog"
                                >
                                  Save
                                </v-btn>
                              </v-card-actions>
                            </v-card>
                          </v-dialog>
                          <v-dialog v-model="delFeatDialog" max-width="570px">
                            <v-card>
                              <v-card-title class="text-h5"
                                >¿Desea eliminar esta
                                Caracteristica?</v-card-title
                              >
                              <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                  color="blue darken-1"
                                  text
                                  @click="closeDelFeatDialog()"
                                  >Cancelar</v-btn
                                >
                                <v-btn
                                  color="blue darken-1"
                                  text
                                  @click="deleteFeature()"
                                  >OK</v-btn
                                >
                                <v-spacer></v-spacer>
                              </v-card-actions>
                            </v-card>
                          </v-dialog>
                        </v-toolbar>
                      </template>
                      <template v-slot:item.action="{ item }">
                        <v-icon small @click="deleteFeatItem(item)">
                          mdi-delete
                        </v-icon>
                      </template>
                    </v-data-table>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="details = false">
                Close
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <!-- details end -->
        <v-dialog v-model="dialogDelete" max-width="570px">
          <v-card>
            <v-card-title class="text-h5"
              >¿Esta seguro que desea eliminar este Producto?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete"
                >Cancelar</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
      <v-container>
        <v-row>
          <v-col>
            <v-text-field
              class="mt-3"
              flat
              label="Buscar"
              hide-details
              v-model="searchString"
              append-icon="mdi-magnify"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-select
              label="Filtrar por Categoria"
              :items="categories"
              chips
              clearable
              class="pa-3"
              v-model="selectCategory"
            ></v-select>
          </v-col>
        </v-row>
        <v-btn color="primary" @click="getData"> Buscar</v-btn>
      </v-container>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
    </template>
  </v-data-table>
</template>

<script>
import { mapState, mapActions } from "vuex";
import ApiService from "../util/ApiService";
export default {
  name: "MainView",
  components: {},
  data: () => ({
    dialog: false,
    dialogDelete: false,
    featDialog: false,
    delFeatDialog: false,
    selectCategory: "",
    searchString: "",
    code: "",
    details: false,
    search: "",
    category: null,
    pCode: null,
    pName: "",
    pCategory: "",
    headers: [
      {
        text: "Codigo",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "Nombre", value: "name" },
      { text: "Categoria", value: "category" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    headerDetails: [
      { text: "Caracteristica", value: "feature" },
      { text: "Valor", value: "value" },
      { text: "Acciones", value: "action", sortable: false },
    ],
    products: [],
    productDetails: [],
    editedIndex: -1,
    editedFeatIndex: -1,
    editedItem: {
      id: 0,
      name: "",
      category: "",
    },
    defaultItem: {
      id: 0,
      name: "",
      category: "",
    },
    editedFeature: {
      feature: "",
      value: "",
      id: 0,
    },
    defaultFeature: {
      feature: "",
      value: "",
      id: 0,
    },
  }),

  computed: {
    ...mapState(["categories", "features"]),
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Producto" : "Editar Producto";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    featDialog(val) {
      val || !this.featDialog;
    },
    delFeatDialog(val) {
      val || this.closeDelFeatDialog();
    },
    details(val) {
      val || this.closeDetails();
    },
  },

  created() {
    this.laod();
  },

  methods: {
    ...mapActions(["fetchCategories", "fetchFeatures"]),
    selectFeature(item) {
      this.details = true;
      this.pCode = item.id;
      this.pName = item.name;
      this.pCategory = item.category;
      this.fetchFeatures(item.id);
    },
    laod() {
      this.fetchCategories();
    },
    getData() {
      ApiService({
        url:
          "/product?" +
          (this.searchString ? "&name=" + this.searchString : " ") +
          (this.selectCategory ? "&category=" + this.selectCategory : " "),
        method: "get",
      })
        .then((resp) => {
          console.log(resp.data);
          this.products = resp.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    editItem(item) {
      this.editedIndex = this.products.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.products.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      ApiService({
        url: "/product/" + this.editedItem.id,
        method: "delete",
      })
        .then(() => {
          console.log("Product deleted!");
        })
        .catch((err) => {
          console.log(err);
        });
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelFeatDialog() {
      this.delFeatDialog = false;
      this.$nextTick(() => {
        this.editedFeature = Object.assign({}, this.defaultFeature);
        this.editedFeatIndex = -1;
      });
    },

    closeFeatDialog() {
      this.FeatDialog = false;
      this.$nextTick(() => {
        this.editedFeature = Object.assign({}, this.defaultFeature);
        this.editedFeatIndex = -1;
      });
    },
    closeDetails() {
      this.details = false;
    },
    deleteFeatItem(item) {
      console.log(item);
      this.editedFeatIndex = this.productDetails.indexOf(item);
      this.editedFeature = Object.assign({}, item);
      this.delFeatDialog = true;
    },

    deleteFeature() {
      ApiService({
        url: `/feature/${this.editedFeature.id}`,
        method: "delete",
      })
        .then(() => {
          console.log("Feature deleted!");
          this.closeDelFeatDialog();
          this.fetchFeatures(this.pCode);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    saveFeatDialog() {
      const newFeature = {
        feature: this.editedFeature.feature,
        value: this.editedFeature.value,
        pid: this.pCode,
      };
      ApiService({
        url: "/feature",
        method: "post",
        data: { ...newFeature },
      })
        .then(() => {
          console.log("Feature saved!");
          this.featDialog = false;
          this.editedFeature = Object.assign({}, this.defaultFeature);
          this.editedFeatIndex = -1;
          this.fetchFeatures(this.pCode);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    save() {
      if (this.editedIndex > -1) {
        ApiService({
          url: "/product/" + this.editedItem.id,
          method: "put",
          data: { ...this.editedItem },
        })
          .then(() => {
            console.log("Product updated!");
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        ApiService({
          url: "/product",
          method: "post",
          data: { ...this.editedItem },
        })
          .then(() => {
            console.log("Product saved!");
          })
          .catch((err) => {
            console.log(err);
          });
      }
      this.close();
    },
  },
};
</script>
