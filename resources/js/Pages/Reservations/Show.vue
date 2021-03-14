<template>
  <app-layout>

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Reserver une plage de travail
      </h2>
    </template>

    <div>
      <div class="mx-auto py-4 sm:px-2 lg:px-4">
        <main>
          <div class="antialiased sans-serif bg-gray-100 h-screen">
            <div class="">
              <div class="container mx-auto px-4 py-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                  <div class="flex items-center justify-between py-2 px-6">
                    <div>
                      <span class="text-lg font-bold text-gray-800">{{MONTH_NAMES[month]}}</span>
                      <span class="ml-1 text-lg text-gray-600 font-normal">{{year}}</span>
                    </div>
                    <div class="border rounded-lg px-1" style="padding-top: 2px;">
                      <button
                          type="button"
                          class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center"
                          :class="{'cursor-not-allowed opacity-25': month == 0 }"
                          :disabled="month == 0 ? true : false"
                          @click="month--; getNoOfDays()">
                        <svg class="h-6 w-6 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                      </button>
                      <div class="border-r inline-flex h-6"></div>
                      <button
                          type="button"
                          class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1"
                          :class="{'cursor-not-allowed opacity-25': month == 11 }"
                          :disabled="month == 11 ? true : false"
                          @click="month++; getNoOfDays()">
                        <svg class="h-6 w-6 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                      </button>
                    </div>
                  </div>

                  <div class="-mx-1 border-t-2 border-red-600">
                    <div class="flex flex-wrap">
                      <template v-for="(day, index) in DAYS" :key="index">
                        <div :style="width" class="px-2 py-2">
                          <div class="text-gray-600 text-sm uppercase tracking-wide font-bold text-center">
                            {{day}}
                          </div>
                        </div>
                      </template>
                    </div>

                    <div class="flex flex-wrap border-t border-l">
                      <template v-for="blankday in blankdays">
                        <div
                            :style="[width, style]"
                            class="text-center border-r border-b px-4 pt-2"
                        ></div>
                      </template>
                      <template v-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                        <div :style="[width, style]" class="px-4 pt-2 border-r border-b relative">
                          <div class="flex">
                            <div
                                class="inline-flex w-6 h-6 items-center justify-center cursor-pointer text-center leading-none rounded-full transition ease-in-out duration-100"
                                :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"
                            >
                              {{date}}
                            </div>
                            <button class="ml-auto" @click="showEventModal(date)">
                              <svg class="w-5 p-1 bg-indigo-500 text-white rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                              </svg>
                            </button>
                          </div>
                          <div class="mt-1 h-5/6 overflow-y-auto">
                            <template v-for="event in events.filter(e => new Date(e.day).toDateString() ===  new Date(year, month, date).toDateString() )">
                                <div>
                                  <div class="bottom flex-grow h-30 py-1 w-full cursor-pointer">
                                    <div class="event rounded py-1 px-2 text-sm mb-1"
                                         @click="showEventModalEvent(event)"
                                         :class="{
                                          'border-blue-200 text-blue-800 bg-blue-100': event.description === 'blue',
                                          'border-red-200 text-red-800 bg-red-100': event.description === 'red',
                                          'border-yellow-200 text-yellow-800 bg-yellow-100': event.description === 'yellow',
                                          'border-green-200 text-green-800 bg-green-100': event.description === 'green',
                                          'border-purple-200 text-purple-800 bg-purple-100': event.description === 'purple'
                                          }">
                                      <span class="event-name">
                                       {{ event.libelle }}
                                      </span>
                                      <span class="time">(Time)</span>
                                    </div>
                                  </div>
                                </div>
                            </template>
                          </div>
                        </div>
                      </template>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal -->
              <div style=" background-color: rgba(0, 0, 0, 0.8)" class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full" v-show.transition.opacity="openEventModal">
                <div class="p-4 max-w-xl mx-auto relative absolute left-0 right-0 overflow-hidden mt-24">
                  <div class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center cursor-pointer"
                       v-on:click="openEventModal = !openEventModal">
                    <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                      <path
                          d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                    </svg>
                  </div>

                  <div class="shadow w-full rounded-lg bg-white overflow-hidden w-full block p-8">

                    <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">
                      {{ activeEvent ? 'Update Event Details' : 'Add Event Details' }}
                    </h2>

                    <div class="mb-4">
                      <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Event title</label>
                      <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" v-model="form.libelle">
                    </div>

                    <div class="mb-4">
                      <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Event date</label>
                      <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" v-model="form.day" readonly>
                    </div>

                    <div class="mb-4">
                      <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Start Hour</label>
                      <input class="time bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" v-model="form.startHour">
                    </div>

                    <div class="mb-4">
                      <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">End Hour</label>
                      <input class="time bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" v-model="form.endHour">
                    </div>

                    <div class="inline-block w-64 mb-4">
                      <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Select a theme</label>
                      <div class="relative">
                        <select v-on:change="form.description = $event.target.value;" v-model="form.description" class="block appearance-none w-full bg-gray-200 border-2 border-gray-200 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-gray-700">
                          <template v-for="(theme, index) in themes">
                            <option :value="theme.value">{{theme.label}}</option>
                          </template>
                        </select>

                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                      </div>
                    </div>

                    <div class="mt-8 text-right">
                      <button type="button" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2" @click="openEventModal = !openEventModal"
                        :disabled="form.processing">
                        Cancel
                      </button>
                      <button type="button" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm" @click="saveEvent()"
                              :disabled="form.processing">
                        {{ activeEvent ? 'Update Event' : 'Save Event' }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Modal -->
            </div>
          </div>
        </main>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import flatpickr from "flatpickr";
import 'flatpickr/dist/flatpickr.css'

export default {
  created() {
    this.initDate();
    this.getNoOfDays();
    this.events = this.reservations;
    // let $inputs = document.querySelectorAll('.time')
    // for (let i = 0; i < $inputs.length; i++) {
    //   flatpickr($inputs[i], {
    //     enableTime: true,
    //     noCalendar: true,
    //     dateFormat: "H:i",
    //     time_24hr: true
    //   });
    // }
    console.log(this.reservations)
  },
  components: {
    AppLayout,
  },
  props: {
    reservations: {type: Array, default: []}
  },
  data() {
    return {
      MONTH_NAMES: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      DAYS: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      month: '',
      year: '',
      width: {
        width: '14.28%'
      },
      style: {
        minHeight: '200px',
        maxHeight: '320px'
      },
      activeEvent: null,
      no_of_days: [],
      blankdays: [],
      days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      events: [],
      themes: [
        {
          value: "blue",
          label: "Blue Theme"
        },
        {
          value: "red",
          label: "Red Theme"
        },
        {
          value: "yellow",
          label: "Yellow Theme"
        },
        {
          value: "green",
          label: "Green Theme"
        },
        {
          value: "purple",
          label: "Purple Theme"
        }
      ],
      openEventModal: false,
      form: this.$inertia.form({
        libelle: '',
        day: '',
        startHour: '',
        endHour: '',
        description: 'blue',
      })
    }
  },
  methods: {
    initDate() {
      let today = new Date();
      this.month = today.getMonth();
      this.year = today.getFullYear();
      this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
    },

    isToday(date) {
      const today = new Date();
      const d = new Date(this.year, this.month, date);

      return today.toDateString() === d.toDateString() ? true : false;
    },

    showEventModal(date) {
      // open the modal
      this.openEventModal = true;
      this.form.day = new Date(this.year, this.month, date).toDateString();
    },

    showEventModalEvent(event) {
      // open the modal
      this.openEventModal = true;
      this.activeEvent = event;
      this.form.day = event.day
      this.form.description = event.description
      this.form.libelle = event.libelle
      this.form.startHour = event.startHour
      this.form.endHour = event.endHour
    },

    saveEvent() {
      if (this.libelle == '') {
        return;
      }

      if (this.activeEvent) {
        let eventId = this.events.indexOf(this.activeEvent);
        this.events[eventId].day= this.day;
        this.events[eventId].libelle= this.libelle;
        this.events[eventId].description= this.description;
      } else {
        this.form.post(this.route('reservations.store'), {
          onFinish: () => this.endSubmit(),
        })

        this.events.push({
          day: this.form.day,
          libelle: this.form.libelle,
          description: this.form.description,
          startHour: this.form.startHour,
          endHour: this.form.endHour
        });
      }
    },

    endSubmit() {
      this.form.reset('libelle', 'day', 'startHour', 'endHour', 'description')
      // clear the form data
      // this.libelle = '';
      // this.day = '';
      // this.startHour = '';
      // this.endHour = '';
      // this.description = 'blue';
      this.activeEvent = null;

      //close the modal
      this.openEventModal = false;
    },

    getNoOfDays() {
      let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

      // find where to start calendar day of week
      let dayOfWeek = new Date(this.year, this.month).getDay();
      let blankdaysArray = [];
      for ( var i=1; i <= dayOfWeek; i++) {
        blankdaysArray.push(i);
      }

      let daysArray = [];
      for ( var i=1; i <= daysInMonth; i++) {
        daysArray.push(i);
      }

      this.blankdays = blankdaysArray;
      this.no_of_days = daysArray;
    }
  },

  watch: {
    openEventModal(newValue) {
      if (!newValue) {
        this.activeEvent = null;
      }
    }
  }
}
</script>

<style scoped>

</style>