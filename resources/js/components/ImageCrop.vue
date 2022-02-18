<template>
  <div>
    <vue-cropper
      ref="cropper"
      :src="src"
      :alt="alt"
      :zoomable="false"
      @ready="init"
    />
    <div
      class="text-center"
      v-show="showButton"
    >
      <button
        class="btn btn-primary"
        type="button"
        @click="save"
      >
        {{ saveLabel }}
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';

export default {
    components: {
        VueCropper,
    },

    props: {
        seasonId: {
            type: [Number, String],
            required: true,
        },

        name: {
            type: String,
            required: true,
        },

        src: {
            type: String,
            required: true,
        },

        alt: {
            type: String,
            required: true,
        },

        square: {
            type: Boolean,
            default: false,
        },

        saveLabel: {
            type: String,
            default: 'Save',
        },
    },

    data() {
        return {
            showButton: false,
        };
    },

    methods: {
        init() {
            const { cropper } = this.$refs;
            const { width, height } = cropper.getImageData();

            if (this.square) {
                cropper.setAspectRatio(1);
            }

            cropper.setCropBoxData({
                top: 0,
                left: 0,
                width,
                height,
            });

            this.showButton = true;
        },

        save() {
            axios
                .patch(`/api/admin/season/${parseInt(this.seasonId, 10)}/image`, {
                    name: this.name,
                    ...this.getCropBoxData(),
                })
                .then(() => {
                })
                .catch(() => {
                });
        },

        getCropBoxData() {
            const { cropper } = this.$refs;
            const cropBox = cropper.getCropBoxData();
            const image = cropper.getImageData();

            const horizontalRatio = image.naturalWidth / image.width;
            const verticalRatio = image.naturalHeight / image.height;

            return {
                top: cropBox.top * verticalRatio,
                left: cropBox.left * horizontalRatio,
                width: cropBox.width * horizontalRatio,
                height: cropBox.height * verticalRatio,
            };
        },
    },
};
</script>
