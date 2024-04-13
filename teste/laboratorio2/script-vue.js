new Vue({
    el: '#app',
    data: {
        excelData: [],
        processedData: [],
    },
    methods: {
        handleFile(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    this.excelData = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
                };
                reader.readAsArrayBuffer(file);
            }
        },
        processWorkbook() {
            this.processedData = this.excelData
                .filter(row => row.EXAMES.includes('TROP'))
                .map(row => ({
                    CLIENTE: row.CLIENTE,
                    ATENDIMENTO: this.formatAtendimento(row.ATENDIMENTO),
                    EXAMES: 'TROPQ',
                    DATA_NASC: "",
                    NOME_MAE: "",
                }));
        },
        formatAtendimento(atendimento) {
            // Assuming the format is always "MA-XXXX-XXXX-XX", where X is a digit
            const atendimentoParts = atendimento.split('-');
            return atendimentoParts.slice(2).join('-');
        },
        exportToExcel() {
            const ws = XLSX.utils.json_to_sheet(this.processedData);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Resultados');
            XLSX.writeFile(wb, 'resultados.xlsx');
        },
    },
});
