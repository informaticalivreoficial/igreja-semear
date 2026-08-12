<div>
    <div
        x-data="calendarComponent()"
        x-init="init()"
        wire:ignore
    >

        <div id="calendar"></div>

    </div>
</div>

@push('scripts')
<script>
    function calendarComponent() {

        return {

            calendar: null,

            init() {

                this.calendar = new Calendar(
                    document.getElementById('calendar'),
                    {

                        plugins: [
                            dayGridPlugin,
                            interactionPlugin
                        ],

                        initialView: 'dayGridMonth',

                        locale: 'pt-br',

                        height: 'auto',

                        events: @js($this->getEvents()),

                        dateClick: (info) => {

                            Livewire.dispatch(
                                'selectDate',
                                { date: info.dateStr }
                            )

                        },

                        eventClick: (info) => {

                            Livewire.dispatch(
                                'editDate',
                                { id: info.event.id }
                            )

                        }
                    }
                )

                this.calendar.render()
            }
        }
    }
</script>
@endpush
