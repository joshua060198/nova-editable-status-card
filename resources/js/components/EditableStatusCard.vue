<template>
  <div class="p-4">
    <div class="flex flex-wrap -m-4">
      <div
        v-for="(card, index) in panel.fields"
        :key="card.key"
        :class="'p-4 ' + cards_size"
      >
        <div
          class="rounded overflow-hidden shadow-lg text-center"
          :style="{
            color: card.text_color[card.value],
            backgroundColor: card.background_color[card.value],
          }"
          :id="'card_container' + index"
        >
          <div class="px-6 py-4">
            <div
              :class="'font-bold mt-4 mb-6 text-center smallcaps ' + title_size"
            >
              <span v-if="card.title">
                {{ card.title }}
              </span>
              <span v-else> Editable Status Card </span>
            </div>
            <hr
              :style="{
                border: '1px solid ' + card.text_color[card.value],
              }"
            />
            <div class="flex space-x-4 mt-6 items-center">
              <img :class="icon_width_size" :src="card.icon" v-if="card.icon" />
              <div
                :class="
                  'text-center w-full mx-6 uppercase smallcaps ' + status_size
                "
              >
                {{ card.data[card.value] }}
              </div>
            </div>
          </div>
          <button
            class="bg-transparent hover:bg-white font-semibold hover-text-black py-2 px-4 border border-black hover-border-transparent rounded my-6 outline-none uppercase"
            :style="{
              color: card.text_color[card.value],
              borderColor: card.text_color[card.value],
              minWidth: 'calc(100% - 3em)',
            }"
            v-on:click="toggleEditField(index, $event)"
            v-if="editPermission"
          >
            Edit
          </button>
          <div
            class="edit-field grid gap-10 transition-all ease-in-out duration-300 bg-white"
            :id="'editField' + index"
          >
            <div
              class="flex flex-wrap justify-center px-2 py-3 w-full cursor-pointer"
            >
              <div
                class="choices rounded-full bg-success mx-2 p-3"
                v-for="(item, index2) in card.data"
                :style="{
                  backgroundColor: card.background_color[index2],
                  width: choices_size,
                  height: choices_size,
                }"
                :key="item"
                v-on:mouseover="choiceMouseOver(index, index2)"
                v-on:mouseleave="choiceMouseLeave(index, index2)"
                v-on:click="choiceClicked(index, index2, $event)"
              ></div>
            </div>
            <hr class="border-black mb-3 mt-0 text-black" />
            <div
              class="flex justify-between items-center text-gray-900 my-3 mx-3"
            >
              <div class="text-center w-full">
                <span
                  :class="
                    'flex-1 text-black text-bold uppercase ' + edit_field_size
                  "
                  :id="'preview_text' + index"
                ></span>
                <span
                  :class="
                    'flex-1 text-black text-bold uppercase ' + edit_field_size
                  "
                  :style="{ color: currentTextColor }"
                  :id="'clicked_text' + index"
                ></span>
              </div>
              <button
                :class="
                  'px-6 py-2 transition ease-in duration-200 uppercase rounded-full hover-bg-gray-800 hover:text-white border-2 border-gray-900 focus:outline-none ' +
                  save_button_size
                "
                v-on:click="save(index, $event)"
              >
                save
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["resourceName", "resourceId", "panel"],

  data: {
    editPermission: false,
    currentBackgroundColor: "#fff",
    currentTextColor: "#000",
    cards_size: "w-1/5",
    title_size: "text-xl",
    status_size: "text-2xl",
    edit_field_size: "text-sm",
    icon_width_size: "w-16",
    choices_size: "15px",
    save_button_size: "text-sm",
  },

  mounted: function () {
    this.checkPermission();
    this.getComponentSizes();
  },

  methods: {
    checkPermission() {
      const self = this;
      const resourceName = this.resourceName;
      Nova.request()
        .post("/nova-vendor/editable-status-card/allowediting", {
          resourceName: resourceName,
        })
        .then((result) => {
          self.editPermission = result.data.result;
          self.$forceUpdate();
        });
    },
    getComponentSizes() {
      const self = this;
      const resourceName = this.resourceName;
      Nova.request()
        .post("/nova-vendor/editable-status-card/sizes", {
          resourceName: resourceName,
        })
        .then((result) => {
          self.cards_size = result.data.result["cards_size"];
          self.title_size = result.data.result["title_size"];
          self.status_size = result.data.result["status_size"];
          self.edit_field_size = result.data.result["edit_field_size"];
          self.icon_width_size = result.data.result["icon_width_size"];
          self.choices_size = result.data.result["choices_size"];
          self.save_button_size = result.data.result["save_button_size"];
          self.$forceUpdate();
        });
    },
    choiceMouseOver(index1, index2) {
      const currentTextColor = this.panel.fields[index1].background_color[
        index2
      ];
      const currentText = this.panel.fields[index1].data[index2];

      const el = document.getElementById("preview_text" + index1);
      el.innerHTML = currentText;
      el.style.color = currentTextColor;
      el.style.display = "";

      const click_el = document.getElementById("clicked_text" + index1);
      click_el.style.display = "none";
    },
    choiceMouseLeave(index1, index2) {
      const el = document.getElementById("preview_text" + index1);
      el.style.display = "none";

      const click_el = document.getElementById("clicked_text" + index1);
      click_el.style.display = "";
    },
    choiceClicked(index1, index2, e) {
      const currentTextColor = this.panel.fields[index1].background_color[
        index2
      ];
      const currentText = this.panel.fields[index1].data[index2];

      const click_el = document.getElementById("clicked_text" + index1);
      click_el.innerHTML = currentText;
      click_el.style.color = currentTextColor;

      const temp = e.target.parentElement.querySelectorAll(".choices");
      for (let i = 0; i < temp.length; i++) {
        temp[i].classList.remove("active");
      }

      e.target.classList.add("active");
    },
    toggleEditField(index, e) {
      const el = document.getElementById("editField" + index);
      el.classList.toggle("active");
      if (el.classList.contains("active")) {
        el.style.height = el.scrollHeight + "px";
        e.target.innerHTML = "Cancel";
      } else {
        el.style.height = "0px";
        e.target.innerHTML = "Edit";
      }
      e.target.blur();
    },
    save(index, e) {
      const self = this;
      const selected_data = this.panel.fields[index].data;
      const value_text = e.target.parentElement.querySelector(
        "#clicked_text" + index
      ).innerHTML;

      let value = 0;

      for (let i = 0; i < this.panel.fields[index].data.length; i++) {
        if (this.panel.fields[index].data[i] == value_text) {
          value = i;
          break;
        }
      }

      Nova.request()
        .post("/nova-vendor/editable-status-card/save", {
          resourceName: self.resourceName,
          resourceId: self.resourceId,
          attribute: self.panel.fields[index].attribute,
          value: value,
        })
        .then(function (response) {
          if (response.data.error) {
            self.$toasted.show(response.data.error, {
              type: "error",
            });
          } else {
            self.$toasted.show(response.data.data, {
              type: "success",
            });
            self.panel.fields[index].value = value;
            document.getElementById("preview_text" + index).innerHTML = "";
            document.getElementById("clicked_text" + index).innerHTML = "";
            const temp = e.target.parentElement.parentElement.parentElement.querySelectorAll(
              ".choices"
            );
            for (let i = 0; i < temp.length; i++) {
              temp[i].classList.remove("active");
            }

            const temp2 = e.target.parentElement.parentElement.parentElement.querySelector(
              "button"
            );
            console.log(e.target.parentElement.parentElement.parentElement);
            temp2.click();

            self.$forceUpdate();
          }
        })
        .catch(function (error) {
          self.$toasted.show(error.response, { type: "error" });
        });
    },
  },
};
</script>
