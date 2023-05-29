<template v-show="openned">
  <v-dialog
    scrollable
    v-model="dialog"
    persistent
    :fullscreen="fullscreen"
    overlay-opacity="0.3"
    overlay-color="black"
    :width="size_"
    transition="false"
  >
    <v-card
      :height="height"
      :min-height="height || '650px'"
      :color="color"
      :style="cardStyle"
    >
      <!-- <v-card-title> -->
      <v-toolbar fixed flat :color="titleColor" dark>
        <v-toolbar-title>
          {{ title }}
          <div style="font-size: 0.9rem" class="subheading" v-if="subtitle">
            {{ subtitle }}
          </div>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-list-item-action
          v-for="(action, indexAction) in actions || []"
          :key="indexAction"
        >
          <template v-if="action.condition ? action.condition() : true">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn
                  v-on="on"
                  tile
                  @click="exec(action)"
                  :color="action.color"
                >
                  <v-icon
                    v-if="action.icon"
                    color="white"
                    v-html="action.icon"
                    :left="!action.text && !action.title === false"
                  />
                  {{ action.title || action.text }}
                </v-btn>
              </template>
              <span>{{ action.help || "" }}</span>
            </v-tooltip>
          </template>
        </v-list-item-action>
        <v-list-item-action>
          <v-btn @click="close" :color="titleColor" tile>
            <v-icon class="heading">mdi-close</v-icon>
          </v-btn>
        </v-list-item-action>
      </v-toolbar>
      <!-- </v-card-title> -->
      <v-card-text>
        <div ref="dialog_body" :id="id"></div>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  /* eslint-disable */
  name: "Dialog",
  props: {
    size: String,
    height: String,
    color: String,
    fullscreen: {
      type: Boolean,
      default: false,
    },
    title: String,
    titleColor: {
      type: String,
      default: "primary",
    },
    subtitle: String,
    cardStyle: String,
    onClose: Function,
    actions: Array,
  },
  beforeCreate() {
    if (this.$vuetify.breakpoint.smAndDown) {
      document.getElementsByTagName("body")[0].className = "noscroll";
    }
  },
  beforeDestroy() {
    document.body.removeAttribute("class", "noscroll");
  },
  data: () => ({
    dialog: true,
    openned: false,
    id: new Date().getTime(),
    sizes: {
      small: "400px",
      medium: "700px",
      large: "900px",
      "x-large": "90%",
      xl: "90%",
    },
  }),
  methods: {
    open() {
      this.openned = true;
    },
    close() {
      if (this.onClose) {
        this.onClose();
      }
      this.$destroy();
    },
    clean() {
      this.$refs.dialog_body.firstChild.remove();
    },
    exec(action) {
      action.action();
    },
  },
  computed: {
    size_() {
      return this.sizes[this.size ? this.size : "medium"];
    },
  },
};
</script>

<style lang="scss" scoped>
.v-card__text {
  height: 100% !important;
  padding: unset !important;
}
</style>
