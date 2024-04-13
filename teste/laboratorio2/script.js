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
                    ATENDIMENTO: row.ATENDIMENTO,
                    EXAMES: row.EXAMES,
                }));
        },
    },
});
