<v-card class="p-2 mt-5">
           <v-row>
              <table class="table">
                  <thead>
                    <th >#</th>
                    <th >Reference #No</th>
                    <th >Total</th>
                    <th >Paid Amount</th>
                    <th>Status</th>
                    <th >Date</th>
                  </thead>
                  <tbody v-for="(invoice,index) in customer.invoices" :key="invoice.id">
                    <td cols="1">{{index+1}}</td>
                    <td cols="5"><router-link :to="`/invoices/${invoice.id}`">{{invoice.counter_number}}</router-link></td>
                    <td cols="2">GH¢{{invoice.total |formatMoney}}</td>
                    <td cols="2" v-for="(payment,i) in customer.payments" :key="payment.id" v-if="payment.invoice_id == invoice.id" >
                        <span style="display:inline">GH¢{{ customer.payments[i].amount_paid|formatMoney}}</span>
                    </td>
                    <td v-for="(payment,i) in customer.payments" v-if="payment.invoice_id === invoice.id">
                        <span v-if="customer.payments[i].amount_paid === invoice.total">
                            <v-chip
                            class="ma-2"
                            color="success"
                            text-color="white"
                            >
                            full payment
                            </v-chip>
                        </span>
                        <span v-else-if="customer.payments[i].amount_paid > 0 && customer.payments[i].amount_paid < invoice.total">
                        <v-chip
                        class="ma-2"
                        color="warning"
                        text-color="white"
                        >
                        part payment
                        </v-chip>
                        </span>
                        <span v-else>
                            <v-chip
                            class="ma-2"
                            color="error"
                            text-color="white"
                            >
                            none
                            </v-chip>
                        </span>
                    </td>
                    <td cols="2">{{invoice.date}}</td>
                  </tbody>
              </table>
          </v-row> 
      </v-card>