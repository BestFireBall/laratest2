<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="alert alert-success text-green-900">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <label class="block">
                            <span class="text-gray-700">Кадастровый номер</span>
                            <input name="cadastral" type="text" class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" placeholder="52:18:0070259:1826">
                        </label>
                        <x-primary-button class="ms-3 mt-2">
                            {{ __('Получить данные') }}
                        </x-primary-button>
                    </form>
                </div>

                <div x-data="data()" class="p-6 text-gray-900">
                    <table class="border-collapse border border-slate-400">
                        <thead>
                            <tr>
                                <th @click="sortByColumn" class="border border-slate-300 cursor-pointer select-none ...">ID &#11015;</th>
                                <th @click="sortByColumn" class="border border-slate-300 cursor-pointer select-none ...">Кадастровый номер &#11015;</th>
                                <th @click="sortByColumn" class="border border-slate-300 cursor-pointer select-none ...">Адрес <br> &#11015;</th>
                                <th @click="sortByColumn" class="border border-slate-300 cursor-pointer select-none ...">Дата создания &#11015;</th>
                                <th @click="sortByColumn" class="border border-slate-300 cursor-pointer select-none ...">Дата обновления &#11015;</th>
                                <th @click="sortByColumn" class="border border-slate-300 cursor-pointer select-none ...">Собственники &#11015;</th>
                                <th @click="sortByColumn" class="border border-slate-300 cursor-pointer select-none ...">Ограничения &#11015;</th>
                                <th class="border border-slate-300 ...">Подробнее</th>
                            </tr>
                        </thead>
                        <tbody x-ref="tbody">
                        @foreach($orders as $order)
                            <tr>
                                <td class="border border-slate-300 ...">{{ $order->id }}</td>
                                <td class="border border-slate-300 ...">{{ $order->cadastral_number }}</td>
                                <td class="border border-slate-300 ...">{{ $order->address }}</td>
                                <td class="border border-slate-300 ...">{{ $order->date_create }}</td>
                                <td class="border border-slate-300 ...">{{ $order->date_update }}</td>
                                <td class="border border-slate-300 ...">{{ $order->owners }}</td>
                                <td class="border border-slate-300 ...">{{ $order->restrictions }}</td>
                                <td class="border border-slate-300 ...">
                                    <form method="GET" action="/orders/{{ $order->id }}">
                                    @csrf
                                        <x-primary-button class="ms-3 mt-2">
                                            {{ __('Получить') }}
                                        </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function data() {
        return {
            sortBy: "",
            sortAsc: false,
            sortByColumn($event) {
                if (this.sortBy === $event.target.innerText) {
                    if (this.sortAsc) {
                        this.sortBy = "";
                        this.sortAsc = false;
                    } else {
                        this.sortAsc = !this.sortAsc;
                    }
                } else {
                    this.sortBy = $event.target.innerText;
                }

                let rows = this.getTableRows()
                    .sort(
                        this.sortCallback(
                            Array.from($event.target.parentNode.children).indexOf(
                                $event.target
                            )
                        )
                    )
                    .forEach((tr) => {
                        this.$refs.tbody.appendChild(tr);
                    });
            },
            getTableRows() {
                return Array.from(this.$refs.tbody.querySelectorAll("tr"));
            },
            getCellValue(row, index) {
                return row.children[index].innerText;
            },
            sortCallback(index) {
                return (a, b) =>
                    ((row1, row2) => {
                        return row1 !== "" &&
                        row2 !== "" &&
                        !isNaN(row1) &&
                        !isNaN(row2)
                            ? row1 - row2
                            : row1.toString().localeCompare(row2);
                    })(
                        this.getCellValue(this.sortAsc ? a : b, index),
                        this.getCellValue(this.sortAsc ? b : a, index)
                    );
            }
        };
    }

</script>
