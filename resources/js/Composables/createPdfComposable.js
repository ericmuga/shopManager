// createPdfComposable.js
import axios from 'axios';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

export  function usePdfGenerator(orderLines, props, currentDate) {
  const generatePDF = async () => {
    const lineItems = orderLines.value;

    try {
      const response = await axios.get(route('convertLogo'));
      const logo = response.data.dataUrl;

      const totalRow = ['', '', 'Total Amount', ` Ksh.${formatNumber(calculateTotal(lineItems))}`];
      const vatAmountRow = ['', '', 'VAT Amount', `Ksh.${formatNumber(calculateVATAmount(lineItems))}`];
      const grandTotalRow = ['', '', 'Amt. Inc VAT', `Ksh.${formatNumber(calculateTotal(lineItems) + calculateVATAmount(lineItems))}`];

      const doc = new jsPDF();

      // Add company information with reduced font size
      const companyInfoText = [
        `Email: ${props.companyInfo.email}`,
        `Phone: ${props.companyInfo.phone}`,
        `PIN: ${props.companyInfo.pin}`,
      ];

      // Set the font size for company information
      doc.setFontSize(8);

      // Add each line of company information
      companyInfoText.forEach((info, index) => {
        doc.text(info.text, doc.internal.pageSize.width - 10, 10 + index * 10, { align: 'right', fontSize: info.fontSize });
      });

      // Add Batian Optical Centre and Sales Invoice headings
      doc.text('Batian Optical Centre', doc.internal.pageSize.width / 2, 20, { align: 'center' });
      doc.text('Sales Invoice', doc.internal.pageSize.width / 2, 30, { align: 'center' });

      // Add date and serial number with reduced font size
      doc.text(`Date: ${currentDate}`, 10, 20, { fontSize: 8 });
      doc.text(`Invoice No.: ${props.lastSerialNo}`, 10, 30, { fontSize: 8 });

      // Calculate the width and height for the centered logo
      const logoWidth = 15; // Adjust as needed
      const logoHeight = (logoWidth * 50) / 50; // Maintain the aspect ratio
      const xPosition = (doc.internal.pageSize.width - logoWidth) / 2;
      const yPosition = 40; // Adjust as needed

      // Add the logo in the center
      doc.addImage(logo, 'JPEG', xPosition, yPosition, logoWidth, logoHeight);

      const columns = ['Item Name', 'Quantity', 'Unit Price', 'Total Amount'];
      const tableBody = lineItems.map(item => [item.itemName + '-' + item.description, item.quantity, `Ksh.${item.price}`, `Ksh.${formatNumber(item.quantity * item.price)}`]);
      tableBody.push(vatAmountRow, totalRow);
      const rows = [columns, ...tableBody];

      // Adjust startY to position the table below the logo and company information
      const tableYPosition = yPosition + logoHeight + 10; // Adjust as needed

      // Set the font size for the table
      const tableFontSize = 8; // Adjust as needed

      doc.autoTable({
        head: [columns],
        body: tableBody,
        theme: 'grid',
        startY: tableYPosition,
        margin: { top: 10 },
        styles: {
          fontSize: tableFontSize,
        },
      });

      // Add the totalRow and vatAmountRow manually
      const totalRowYPosition = tableYPosition + (tableBody.length + 1) * 10; // Adjust as needed
      const vatAmountRowYPosition = totalRowYPosition + 10; // Adjust as needed

      // doc.text(totalRow[2], doc.internal.pageSize.width - 10, totalRowYPosition, { align: 'right', fontSize: 8 });
      // doc.text(totalRow[3], doc.internal.pageSize.width - 10, totalRowYPosition + 10, { align: 'right', fontSize: 8 });
      // doc.text(vatAmountRow[2], doc.internal.pageSize.width - 10, vatAmountRowYPosition, { align: 'right', fontSize: 8 });
      // doc.text(vatAmountRow[3], doc.internal.pageSize.width - 10, vatAmountRowYPosition + 10, { align: 'right', fontSize: 8 });

      doc.save('sales_invoice.pdf');
    } catch (error) {
      console.error('Error fetching image data URL', error);
    }
  };

  return { generatePDF };
}
