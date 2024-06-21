import {useState, Fragment} from 'react';
import { TextField, Button, Stack, FormLabel, RadioGroup, FormControlLabel, Radio, Typography, FormControlLabelProps } from '@mui/material';
import { MuiFileInput } from 'mui-file-input';
import SendIcon from '@mui/icons-material/Send';
import CloseIcon from "@mui/icons-material/Close";
import styled from '@emotion/styled';
import axios from "axios";

const StyledFormControlLabel = styled((props:FormControlLabelProps) => (
  <FormControlLabel {...props} />
))(() => ({
  ".MuiFormControlLabel-asterisk": {
    display: "none"
  }
}));

const RadioGroupOther = (props:any) => {
  return (
    <Fragment>
      <FormLabel id={props.title} required>{props.title}</FormLabel>
      <RadioGroup
        aria-labelledby={props.title}
        value={props.state}
        onChange={e => props.setState(e.target.value)}
        sx={{mb:4}}
      >
        {props.choices.map((choice:any) => {
          return <StyledFormControlLabel value={choice} control={<Radio required/>} label={choice} />
        })}
        <StyledFormControlLabel value="Other" control={<Radio required/>} label="Other" />
      {(props.state === "Other") && <TextField
          type="text"
          variant='outlined'
          color='secondary'
          label="If other, please specify"
          onChange={e => props.setOtherState(e.target.value)}
          value={props.otherState}
          required={props.state === "Other"}
      />}
      </RadioGroup>
    </Fragment>
  )
}

const RegisterForm = () => {
  const [firstName, setFirstName] = useState('')
  const [lastName, setLastName] = useState('')
  const [email, setEmail] = useState('')
  const [university, setUniversity] = useState('')

  const [fos, setFos] = useState('')
  const [otherFos, setOtherFos] = useState('')

  const [attendance, setAttendance] = useState('')
  const [otherAttendance, setOtherAttendance] = useState('')

  const [motivation, setMotivation] = useState('')
  
  const [cv, setCv] = useState<File | null>(null)
  const handleCvChange = (val:File | null) => {
    console.log(val)
    setCv(val)
  }

  async function handleSubmit(event:any) {
      event.preventDefault();
      const data = {
        firstName, lastName, email, university, fos: (fos === "Other") ? otherFos : fos, attendance: (attendance === "Other") ? otherAttendance : attendance, motivation, cv:cv!
      }
      console.log(data)
      await axios.postForm("/submit", data)
  }

  //action={<Link to="/login" />}>
  return (
    <Fragment>

      <form onSubmit={handleSubmit}>
        <Stack spacing={2} direction="row" sx={{marginBottom: 4}}>
          <TextField
              type="text"
              variant='outlined'
              color='secondary'
              label="First Name"
              onChange={e => setFirstName(e.target.value)}
              value={firstName}
              fullWidth
              required
          />
          <TextField
              type="text"
              variant='outlined'
              color='secondary'
              label="Last Name"
              onChange={e => setLastName(e.target.value)}
              value={lastName}
              fullWidth
              required
          />
        </Stack>
        <TextField
            type="email"
            variant='outlined'
            color='secondary'
            label="Email"
            onChange={e => setEmail(e.target.value)}
            value={email}
            fullWidth
            required
            sx={{mb: 4}}
        />
        <TextField
            type="text"
            variant='outlined'
            color='secondary'
            label="University"
            onChange={e => setUniversity(e.target.value)}
            value={university}
            required
            fullWidth
            sx={{mb: 4}}
        />

        <RadioGroupOther title="Field of study" state={fos} setState={setFos} otherState={otherFos} setOtherState={setOtherFos} choices={
          ["Economics", "Business Administration and Management", "Business and Finance", "Computer Science / IT", "Management and commercial engineering", "Civil/Industrial engineering", "Aeronautical engineering", "Mechanical engineering", "Electronical engineering", "Political sciences / International Relations"]
        }/>
        <RadioGroupOther title="Current year of attendance" state={attendance} setState={setAttendance} otherState={otherAttendance} setOtherState={setOtherAttendance} choices={
          ["First year of Bachelor Degree", "Second year of Bachelor Degree", "Third year of Bachelor Degree", "First year of Master's Degree", "Second year of Master's Degree"]
        }/>

        <TextField
            type="text"
            variant='outlined'
            multiline={true}
            minRows={3}
            color='secondary'
            label="In a few words, tell us why you decided to apply for our Business Game"
            onChange={e => setMotivation(e.target.value)}
            value={motivation}
            required
            fullWidth
            sx={{mb: 4}}
        />

        <MuiFileInput
          label="Please attach your CV here"
          required
          value={cv}
          onChange={handleCvChange}
          fullWidth
          sx={{mb: 4}}
          clearIconButtonProps={{
            title: "Remove",
            children: <CloseIcon fontSize="small" />
          }}
        />

        <Typography align="center"><Button variant="outlined" color="primary" type="submit" sx={{mb:4}} endIcon={<SendIcon/>}>Apply</Button></Typography>
      </form>
    </Fragment>
  )
}
 
export default RegisterForm;
