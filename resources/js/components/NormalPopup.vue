<template>
  <div class="popup-wrapper small-popup" :style="style" v-bind="$attrs"
       :class="{'no-fade': !noFade && another_popup_is_opened, [properClass]: true}" v-if="isVisible || !useAsConfirm">
    <div class="popup" :style="{'width': width}" :class="{'100-height': height100}">
      <div class="popup-header" v-if="showHeader" :style="{ borderBottom: noBorder ? '1px solid #e2e2e2' : 'none' }">
        <slot name="header">
        </slot>
      </div>
      <div class="popup-content normal-font" :style="{'height': height, 'padding': bodyPadding, 'border': noBorder ? 'none' : 'solid 1px #e2e2e2' }">
        <slot>
          <p>Popup Content</p>
        </slot>
      </div>
      <div class="popup-bottom">
        <slot name="bottom"></slot>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'NormalPopup',
  props: {
    width: {
      required: false,
      type: String,
    },
    height: {
      required: false,
      type: String,
    },
    showHeader: {
      required: false,
      type: Boolean,
      default: true
    },
    dimmed: {
      required: false,
      type: Boolean,
      default: false
    },
    bodyPadding: {
      type: String,
      default: '20px'
    },
    noBorder: {
      required: false,
      type: Boolean,
      default: false
    },
    transparent: {
      required: false,
      type: Boolean,
      default: false
    },
    noFade: {
      required: false,
      type: Boolean,
      default: false
    },
    properClass: {
      required: false,
      type: String,
      default: ''
    },
    useAsConfirm: {
        required: false,
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      another_popup_is_opened: false,
      isVisible: false,
    }
  },
  computed: {
    height100() {
      return this.another_popup_is_opened || this.dimmed
    },
    style() {
      return {
        backgroundColor: this.transparent ? 'transparent' : 'rgba(0, 0, 0, 0.3);'
      }
    }
  },
  mounted() {
    const big_popups_opened = document.getElementsByClassName('big-popup').length > 0
    if (big_popups_opened) {
      this.another_popup_is_opened = false
      return;
    }
    this.another_popup_is_opened = this.dimmed ? false : document.getElementsByClassName('small-popup').length > 1
  },
  methods: {
    open() {
            this.isVisible = true
        },

        close() {
            this.isVisible = false
        },
  },
}

</script>
<style lang="scss" scoped>

.popup-wrapper {
  position: fixed;
  z-index: 1000;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;

  &.no-fade {
    background-color: transparent;
  }

  .popup {
    background-color: white;
    border-radius: 15px;
    overflow: hidden;
    min-height: 20vh;
    max-height: 90vh;
    min-width: 35vw;
    display: flex;
    flex-direction: column;

    &.height100 {
      height: 100%;
    }
  }

  .popup-header {
    h4 {
      font-weight: 500;
      text-transform: initial;
      font-size: 1.2rem;
    }

    padding: 10px 20px;
  }

  .popup-content {
    overflow: auto;
    font-weight: 400;
    padding: 20px 20px;
    margin: 0;
    text-transform: initial;
    font-size: 1rem;
    color: lighten(black, 10);
    border-top: solid 1px #e2e2e2;
  }

  .popup-bottom {
    /*background-color: darken(whitesmoke, 3);*/
    text-transform: initial;
  }
}

@media (max-width: 1024px) {
  .popup-wrapper {
    .popup {
      width: 450px;
    }
  }
}

</style>