import ReactDOM from 'react-dom/client';
import Form from './Form';
import { Box, CssBaseline, GlobalStyles, Grid, Paper, ThemeProvider, Typography, createTheme } from '@mui/material';

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);

const theme = createTheme({
  palette: {
    primary: {
      main: '#B6313A',
    },
    secondary: {
      main: '#545454',
    },
    background: {
      default: 'white'
    }
  },
  components: {
    MuiInputBase: {
      defaultProps: {
        color:"primary"
      }
    },
    MuiInputLabel: {
      defaultProps:{
        color:"primary"
      }
    }
  },
});

root.render(
  <ThemeProvider theme={theme}>
    <CssBaseline />
    <GlobalStyles
      styles={{
        body: { backgroundColor: "background.default" },
      }}
    />
    <Grid
      container
      spacing={0}
      direction="column"
      alignItems="center"
      justifyContent="center"
    >
      <Grid item xs={3}>
        <Paper elevation={4} sx={{backgroundColor:"white", pl:4, pr:4}}>
          <Box
            width="640px"
            maxWidth="100%"
          >
            <img
              src="./LOGO-SABG-definitivo-3.png"
              alt="Sant'Anna Business Game"
              style={{width:"100%"}}
            />
            <Typography align="center" color="secondary" variant="h4" sx={{mt:4,mb:2}}>Apply for our Business Game</Typography>
            <Typography sx={{mb:4}}>Welcome, we are pleased to meet you and look forward to welcoming you here in Pisa! Please fill the form below with all your personal details and you will be contacted within 72 hours regarding the selection process. </Typography>
            <Form />
          </Box>
        </Paper>
      </Grid>
    </Grid>
  </ThemeProvider>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
// reportWebVitals(console.log);
