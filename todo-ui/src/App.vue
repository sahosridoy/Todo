<script setup>
import { onMounted, ref, watch, reactive } from "vue";
import axios from "axios";

const state = reactive({
  title: "",
});

let error = false;
let errorMessage = "";
const datas = ref([]);
let result = Array;
let changeableId = "";
onMounted(() => {
  fetchData("http://127.0.0.1:8000/api/works");
});

async function fetchData(url) {
  await axios.get(url).then((response) => {
    if (response.data.code === 200) {
      datas.value = response.data.data;
    } else {
      throw Error("Server Side Error");
    }
  });
}

async function submitHandler() {
  if (state.title != "") {
    await axios
      .post("http://127.0.0.1:8000/api/works", state)
      .then((response) => {
        if (response.data.code === 200) {
          fetchData("http://127.0.0.1:8000/api/works");

          state.title = "";
        } else {
          //Show Error message
          console.log(response.data.message);
        }
      })
      .catch((error) => {
        console.log("problem Here" + error);
      });
  }
}

async function changeStatus(id, status) {
  await axios
    .get("http://127.0.0.1:8000/api/works/change-status/" + id + "/" + status)
    .then((response) => {
      if (response.data.code === 200) {
        fetchData("http://127.0.0.1:8000/api/works");
      } else {
        //Show Error message
        console.log(response.data.message);
      }
    })
    .catch((error) => {
      console.log("problem Here" + error);
    });
}
function startDrag(evt, id) {
  evt.dataTransfer.dropEffect = "move";
  evt.dataTransfer.effectAllowed = "move";
  changeableId = id;
}
function onDrop(evt, status) {
  changeStatus(changeableId, status);
}
</script>

<template>
  <main>
    <div class="container">
      <div class="store">
        <form @submit.prevent="submitHandler">
          <div class="d-inline">
            <input
              type="text"
              v-model="state.title"
              placeholder="Write your task ..."
            />
          </div>
          <button class="submit_btn" type="submit">Add</button>
        </form>
      </div>

      <div class="board_main">
        <div class="board">
          <div class="board_title">To Do</div>
          <div
            class="board_body"
            @drop="onDrop($event, 1)"
            @dragover.prevent
            @dragenter.prevent
          >
            <ul v-for="data in datas" :key="data.id">
              <li
                v-if="data.status == 1"
                draggable="true"
                @dragstart="startDrag($event, data.id)"
              >
                {{ data.title }}
              </li>
            </ul>
          </div>
        </div>
        <div class="board">
          <div class="board_title">In Progress</div>
          <div
            class="board_body"
            @drop="onDrop($event, 2)"
            @dragover.prevent
            @dragenter.prevent
          >
            <ul v-for="data in datas" :key="data.id">
              <li
                draggable="true"
                v-if="data.status == 2"
                @dragstart="startDrag($event, data.id)"
              >
                {{ data.title }}
              </li>
            </ul>
          </div>
        </div>
        <div class="board">
          <div class="board_title">Done</div>
          <div
            class="board_body"
            @drop="onDrop($event, 3)"
            @dragover.prevent
            @dragenter.prevent
          >
            <ul v-for="data in datas" :key="data.id">
              <li
                v-if="data.status == 3"
                draggable="true"
                @dragstart="startDrag($event, data.id)"
              >
                {{ data.title }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
main {
  min-height: 500px;
}
ul {
  list-style: none;
  padding: 0;
  margin: 0 20px;
  text-align: center;
}
li {
  background: rgb(203, 203, 212);
  margin: 10px 0;
  padding: 10px;
  width: 100%;
  font-size: 18px;
  border: 1px solid #000;
}
.container {
  width: 1130px;
}
.d-inline {
  display: inline-block;
}
.store {
  text-align: center;
  margin-bottom: 40px;
}
form {
  display: flex;
  justify-content: center;
}

.board_main {
  width: 80%;
  display: flex;
  justify-content: space-between;
  margin: 0 auto;
}
.board {
  border: 1px solid #000;
  color: #000;
  width: 100%;
  margin: 0 10px;
}

.board_title {
  background: orange;
  padding: 10px 0;
  font-size: 22px;
  font-weight: 600;
  text-align: center;
  border-bottom: 1px solid #000;
}
.board_body {
  height: 400px;
  overflow: auto;
}
input {
  margin-right: 10px;
  width: 280px;
  height: 43px;
  padding: 5px 10px;
  font-size: 18px;
}
.submit_btn {
  background: transparent;
  border: 1px solid #000;
  padding: 12px 25px;
  font-weight: 600;
  color: orange;
}
</style>
