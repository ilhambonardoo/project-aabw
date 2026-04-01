document.addEventListener("DOMContentLoaded", function () {
  const btnAddBaris = document.getElementById("btnAddBaris");
  const tbodyRincian = document.getElementById("tbodyRincian");
  const rowTemplate = tbodyRincian.rows[0].outerHTML;

  function formatRupiah(e) {
    let input = e.target;
    let value = input.value.replace(/[^,\d]/g, "");
    let split = value.split(",");
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      let separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;

    input.value = rupiah ? "Rp. " + rupiah : "";

    hitungTotal();
  }

  function parseRupiah(rupiahString) {
    if (!rupiahString) return 0;
    let clean = rupiahString.replace(/Rp\.?\s?/g, "").replace(/\./g, "");
    clean = clean.replace(",", ".");
    return parseFloat(clean) || 0;
  }

  function hitungTotal() {
    let totalDebit = 0;
    let totalKredit = 0;

    document.querySelectorAll(".debit-input").forEach((input) => {
      totalDebit += parseRupiah(input.value);
    });

    document.querySelectorAll(".kredit-input").forEach((input) => {
      totalKredit += parseRupiah(input.value);
    });

    document.getElementById("totalDebit").value = new Intl.NumberFormat(
      "id-ID",
      { style: "currency", currency: "IDR" },
    ).format(totalDebit);
    document.getElementById("totalKredit").value = new Intl.NumberFormat(
      "id-ID",
      { style: "currency", currency: "IDR" },
    ).format(totalKredit);

    const ketBalance = document.getElementById("keteranganBalance");
    if (totalDebit === totalKredit && totalDebit > 0) {
      ketBalance.innerHTML =
        '<span class="text-success"><i class="bi bi-check-circle-fill"></i> Seimbang</span>';
    } else {
      ketBalance.innerHTML =
        '<span class="text-danger"><i class="bi bi-x-circle-fill"></i> Tidak Seimbang</span>';
    }
  }

  function attachEvents(row) {
    const inputDebit = row.querySelector(".debit-input");
    const inputKredit = row.querySelector(".kredit-input");

    inputDebit.addEventListener("keyup", formatRupiah);
    inputKredit.addEventListener("keyup", formatRupiah);
  }

  // Attach events ke semua row yang sudah ada
  Array.from(tbodyRincian.rows).forEach((row) => attachEvents(row));

  // Hitung total pada page load (untuk edit)
  hitungTotal();

  // Event: Tombol Add Baris
  btnAddBaris.addEventListener("click", function () {
    tbodyRincian.insertAdjacentHTML("beforeend", rowTemplate);
    const newRow = tbodyRincian.lastElementChild;

    const btnHapus = newRow.querySelector(".btn-hapus-baris");
    btnHapus.disabled = false;
    btnHapus.removeAttribute("title");

    newRow.querySelector('select[name="id_akun_3[]"]').value = "";
    newRow.querySelector('select[name="status[]"]').value = "";
    newRow.querySelector('input[name="debit[]"]').value = "0";
    newRow.querySelector('input[name="kredit[]"]').value = "0";

    attachEvents(newRow);
  });

  // Event: Tombol Hapus Baris
  tbodyRincian.addEventListener("click", function (e) {
    if (e.target.closest(".btn-hapus-baris")) {
      const row = e.target.closest("tr");
      if (row.rowIndex > 1) {
        row.remove();
        hitungTotal();
      }
    }
  });
});
