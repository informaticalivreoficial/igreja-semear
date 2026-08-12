<div wire:ignore>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('toast', ({ type, message }) => {
                showToast(type, message);
            });
        });

        function showToast(type, message) {
            const colors = {
                success: '#16a34a',
                error: '#dc2626',
                warning: '#f59e0b',
                info: '#2563eb',
            };

            Toastify({
                text: message,
                duration: 4000,
                gravity: "top",
                position: "right",
                close: true,
                style: {
                    background: colors[type] ?? '#2563eb',
                },
            }).showToast();
        }
    </script>
</div>