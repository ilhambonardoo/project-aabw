const akunOptionsHtml =
  document.querySelector("[data-akun-options]")?.innerHTML || "";
const statusOptionsHtml =
  document.querySelector("[data-status-options]")?.innerHTML || "";

function formatRupiahInput(value) {
  let cleanValue = value.replace(/[Rp\s.]/g, "").replace(",", ".");
  let numValue = parseFloat(cleanValue);

  if (isNaN(numValue)) return "0";

  let parts = numValue.toString().split(".");
  let intPart = parts[0];
  let decPart = parts[1] || "";

  let formatted = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

  return decPart ? formatted + "," + decPart : formatted;
}

function parseRupiah(rupiahString) {
  if (!rupiahString) return 0;
  let cleanString = rupiahString
    .replace(/\./g, "")
    .replace(/Rp\s?/g, "")
    .replace(/,/g, ".");
  let val = parseFloat(cleanString);
  return isNaN(val) ? 0 : val;
}

function formatRupiah(angka) {
  let number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    let separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }
  return split[1] != undefined ? rupiah + "," + split[1] : rupiah;
}

function hitungPenyesuaian() {
  const nilaiPerolehan = parseRupiah(
    document.getElementById("nilaiPerolehan").value,
  );
  const masaManfaat =
    parseInt(document.getElementById("masaManfaat").value) || 0;

  let nilaiPenyesuaian = 0;
  if (masaManfaat > 0 && nilaiPerolehan > 0) {
    nilaiPenyesuaian = Math.round(nilaiPerolehan / masaManfaat);
  }

  const nilaiPenyesuaianEl = document.getElementById("nilaiPenyesuaian");
  if (nilaiPenyesuaian > 0) {
    nilaiPenyesuaianEl.value =
      "Rp " + formatRupiahInput(nilaiPenyesuaian.toString());
  } else {
    nilaiPenyesuaianEl.value = "Rp 0";
  }

  // updateSemuaBarisJurnal(nilaiPenyesuaian); // Dinonaktifkan agar tidak otomatis mengisi baris yang sudah ada
}

function updateSemuaBarisJurnal(nilaiPenyesuaian) {
  // Dinonaktifkan agar tidak otomatis mengisi debit/kredit
  /*
  document.querySelectorAll(".baris-jurnal").forEach((row) => {
    ...
  });
  */
  hitungTotal();
}

function hitungTotal() {
  let totalDebit = 0;
  let totalKredit = 0;

  document.querySelectorAll(".input-debit").forEach((input) => {
    totalDebit += parseRupiah(input.value);
  });

  document.querySelectorAll(".input-kredit").forEach((input) => {
    totalKredit += parseRupiah(input.value);
  });

  document.getElementById("totalDebit").textContent =
    "Rp " + formatRupiah(totalDebit.toString());
  document.getElementById("totalKredit").textContent =
    "Rp " + formatRupiah(totalKredit.toString());

  const statusBalance = document.getElementById("statusBalance");
  const btnSimpan = document.getElementById("btnSimpan");

  if (totalDebit > 0 && totalKredit > 0 && totalDebit === totalKredit) {
    statusBalance.innerHTML =
      '<span class="badge badge-success px-3 py-2">Seimbang (Balance)</span>';
    if (btnSimpan) btnSimpan.disabled = false;
  } else {
    statusBalance.innerHTML =
      '<span class="badge badge-danger px-3 py-2">Belum Seimbang</span>';
    if (btnSimpan) btnSimpan.disabled = true;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const nilaiPerolehanEl = document.getElementById("nilaiPerolehan");
  if (nilaiPerolehanEl) {
    nilaiPerolehanEl.addEventListener("keyup", function () {
      if (this.value === "") this.value = "0";
      this.value = formatRupiahInput(this.value);
      hitungPenyesuaian();
    });

    nilaiPerolehanEl.addEventListener("change", function () {
      if (this.value === "") this.value = "0";
      this.value = formatRupiahInput(this.value);
      hitungPenyesuaian();
    });
  }

  const masaManfaatEl = document.getElementById("masaManfaat");
  if (masaManfaatEl) {
    masaManfaatEl.addEventListener("keyup", hitungPenyesuaian);
    masaManfaatEl.addEventListener("change", hitungPenyesuaian);
  }

  document.addEventListener("change", function (e) {
    if (e.target.classList.contains("select-akun")) {
      // Logic pengisian otomatis debit/kredit saat pilih akun telah dihapus
      // Agar pengguna dapat mengisi secara manual
      hitungTotal();
    }
  });

  document.addEventListener("keyup", function (e) {
    if (
      e.target.classList.contains("input-debit") ||
      e.target.classList.contains("input-kredit")
    ) {
      if (e.target.value === "") e.target.value = "0";
      e.target.value = formatRupiah(e.target.value);

      const row = e.target.closest(".baris-jurnal");
      if (e.target.classList.contains("input-debit")) {
        if (parseRupiah(e.target.value) > 0) {
          row.querySelector(".input-kredit").value = "0";
        }
      } else {
        if (parseRupiah(e.target.value) > 0) {
          row.querySelector(".input-debit").value = "0";
        }
      }

      hitungTotal();
    }
  });

  document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-hapus")) {
      const tbody = document.querySelector("#tabelRincian tbody");
      if (tbody.querySelectorAll("tr").length > 1) {
        e.target.closest("tr").remove();
        hitungTotal();
      } else {
        alert("Minimal harus ada 1 baris rincian!");
      }
    }
  });

  const btnAddBaris = document.getElementById("btnAddBaris");
  if (btnAddBaris) {
    btnAddBaris.addEventListener("click", function () {
      const tbody = document.querySelector("#tabelRincian tbody");
      const newRow = document.createElement("tr");
      newRow.className = "baris-jurnal";

      const akunContainer = document.querySelector("[data-akun-options]");
      const statusContainer = document.querySelector("[data-status-options]");

      const akunHtml = akunContainer
        ? akunContainer.innerHTML
        : '<option value="">-- Pilih Akun --</option>';
      const statusHtml = statusContainer
        ? statusContainer.innerHTML
        : '<option value="">-- Pilih Status --</option>';

      newRow.innerHTML = `
                <td>
                    <select class="form-control select-akun" name="id_akun_3[]" required>
                        <option value="">-- Pilih Akun --</option>
                        ${akunHtml}
                    </select>
                </td>
                <td><input type="text" class="form-control text-end input-debit format-rupiah" name="debit[]" value="0" required></td>
                <td><input type="text" class="form-control text-end input-kredit format-rupiah" name="kredit[]" value="0" required></td>
                <td><select class="form-control" name="status[]" required><option value="">-- Pilih Status --</option>${statusHtml}</select></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-hapus"><i class="fas fa-trash"></i>X</button></td>
            `;

      tbody.appendChild(newRow);
      hitungTotal();
    });
  }

  const formTransaksi = document.getElementById("formTransaksi");
  if (formTransaksi) {
    formTransaksi.addEventListener("submit", function (e) {
      const totalDebit = parseRupiah(
        document.getElementById("totalDebit").textContent,
      );
      const totalKredit = parseRupiah(
        document.getElementById("totalKredit").textContent,
      );

      if (totalDebit !== totalKredit || totalDebit === 0) {
        e.preventDefault();
        alert("Transaksi tidak seimbang atau masih kosong!");
      }
    });
  }

  hitungPenyesuaian();
});
