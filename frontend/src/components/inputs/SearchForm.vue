<template>
  <form class="pt-14">
    <v-text-field
      v-model="confirmacion.name"
      :error-messages="nameErrors"
      counter="30"
      label="Codigo"
      required
      color="primary"
      @input=""
      @blur="this.v$.confirmacion.name.$touch()"
    ></v-text-field>
    <v-text-field
      v-model="confirmacion.email"
      :error-messages="emailErrors"
      label="Nombre"
      required
      color="primary"
      @input=""
      @blur="this.v$.confirmacion.email.$touch()"
    ></v-text-field>
    <v-select
      v-model="confirmacion.select"
      :items="confirmacion.items"
      :error-messages="selectErrors"
      label="Categoria"
      required
      color="primary"
      @change="
        isVisible();
        asistire();
      "
      @blur="this.v$.confirmacion.select.touch().prevent"
    ></v-select>

    <v-textarea
      v-if="this.visible"
      hint="Si iras solo escribe Sin Acompañantes"
      v-model="confirmacion.textArea"
      :error-messages="textAreaErrors"
      counter="250"
      clearable
      clear-icon="mdi-close-circle"
      label="Lista a tus Acompañantes"
      color="amber"
      required
      @input=""
      @blur="this.v$.confirmacion.textArea.$touch()"
    ></v-textarea>

    <v-btn class="ma-6" @click="submit"> Confirmar </v-btn>
    <v-btn class="ma-6" @click="clear"> Limpiar </v-btn>
  </form>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, maxLength, email, minLength } from "@vuelidate/validators";
import axios from "axios";

export default {
  name: "Form",
  setup() {
    return {
      v$: useVuelidate(),
    };
  },

  validations() {
    return {
      confirmacion: {
        name: { required, maxLength: maxLength(30), $autoDirty: true },
        email: { required, email, $autoDirty: true },
        select: { required, $autoDirty: true },
        textArea: { required, minLength: minLength(10), $autoDirty: true },
      },
    };
  },

  data: () => ({
    confirmacion: {
      name: "",
      email: "",
      select: null,
      items: ["Sí", "No"],
      textArea: "",
      num: 303,
      comp: "acompañantes",
    },
    visible: false,
  }),

  computed: {
    selectErrors() {
      let errors = [];
      if (!this.v$.confirmacion.select.$dirty) return errors;
      if (this.v$.confirmacion.select.required.$invalid)
        errors.push("Opción Obligatoria");

      return errors;
    },
    nameErrors() {
      const errors = [];
      if (!this.v$.confirmacion.name.$dirty) return errors;

      if (this.v$.confirmacion.name.required.$invalid)
        errors.push("El nombre es requerido");

      if (this.v$.confirmacion.name.maxLength.$invalid)
        errors.push("El nombre no debe exceder los 30 caracteres");

      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.v$.confirmacion.email.$dirty) return errors;

      if (this.v$.confirmacion.email.required.$invalid)
        errors.push("El Correo es Requerido");

      if (this.v$.confirmacion.email.email.$invalid)
        errors.push("Debe ser un Correo Valido");

      return errors;
    },

    textAreaErrors() {
      const errors = [];
      if (!this.v$.confirmacion.textArea.$dirty) return errors;
      this.v$.confirmacion.textArea.required.$invalid &&
        errors.push("Campo Requerido");
      this.v$.confirmacion.textArea.minLength.$invalid &&
        errors.push("El minimo de caracteres es de 10");
      return errors;
    },
  },

  methods: {
    isVisible() {
      if (this.confirmacion.select === "No") this.visible = false;
      else this.visible = true;
    },
    async submit() {
      // this.v$.$touch()
      const result = await this.v$.$validate();

      if (!result) {
        // notify user form is invalid
        this.v$.confirmacion.$touch();
      } else {
        axios
          .post(
            "https://www.monicayeduardo.com/confirmacion/",
            this.confirmacion
          )
          .then((res) => {
            const type = res.data.success ? "success" : "warn";
            console.log(res);

            this.$notify({
              title: res.data.message,
              type: type,
              duration: 5000,
            });
          })
          .catch((err) => {
            console.error(err);
            this.$notify({
              title: err.data.error,
              type: "error",
              duration: 5000,
            });
          });

        this.clear();
      }
      // perform async actions
    },

    clear() {
      this.confirmacion.name = "";
      this.confirmacion.email = "";
      this.confirmacion.select = null;
      this.confirmacion.textArea = "";
      this.visible = false;
      this.v$.$reset();
    },

    asistire() {
      if (this.confirmacion.select === "No")
        this.confirmacion.textArea = "Sin asistencia";
      else this.confirmacion.textArea = "";
    },
  },
};
</script>

<style></style>
